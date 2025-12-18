<?php

namespace App\Http\Controllers\Admin;

use App\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Award;

class PresentationController extends Controller
{
    /**
     * Show presentation slides for an award
     *
     * @param Award $award
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Award $award)
    {
        // Eager load relationships with filters
        $award->load([
            'categories' => function ($query) {
                $query->whereIn('type', [CategoryType::PUBLIC_VOTE, CategoryType::ADMIN_CHOICE])
                      ->orderBy('order', 'asc')
                      ->with([
                          'nominees' => function ($q) {
                              $q->withCount('votes');
                          },
                          'winner' // Para ADMIN_CHOICE
                      ]);
            }
        ]);

        // Validate if there are eligible categories
        if ($award->categories->isEmpty()) {
            return redirect()
                ->route('filament.admin.resources.awards.awards.index')
                ->with('error', 'Esta premiação não possui categorias de votação pública ou escolha do admin.');
        }

        // Build slides array
        $slides = $this->buildSlides($award);

        return view('admin.presentation.show', compact('award', 'slides'));
    }

    /**
     * Build slides array structure
     *
     * @param Award $award
     * @return array
     */
    private function buildSlides(Award $award): array
    {
        $slides = [];

        // Slide 0: Cover
        $slides[] = [
            'type' => 'cover',
            'data' => [
                'name' => $award->name,
                'year' => $award->year,
                'description' => $award->description,
                'cover_image' => $award->cover_image ? asset('uploads/' . $award->cover_image) : null,
            ]
        ];

        // Slide 1: Category List
        $slides[] = [
            'type' => 'category_list',
            'data' => [
                'categories' => $award->categories->map(fn($cat) => [
                    'name' => $cat->name,
                    'type' => $cat->type->value
                ])->toArray()
            ]
        ];

        // For each category: Nominees/Admin Choice → Suspense → Winner
        foreach ($award->categories as $category) {
            // Slide N: Nominees (PUBLIC_VOTE) or Admin Choice Intro (ADMIN_CHOICE)
            if ($category->type === CategoryType::ADMIN_CHOICE) {
                // For admin choice, show simple intro slide
                $slides[] = [
                    'type' => 'admin_choice_intro',
                    'data' => [
                        'category_name' => $category->name,
                        'category_description' => $category->description,
                    ]
                ];
            } else {
                // For public vote, show nominees
                $slides[] = [
                    'type' => 'nominees',
                    'data' => [
                        'category_name' => $category->name,
                        'category_description' => $category->description,
                        'nominees' => $category->nominees->map(fn($nom) => [
                            'id' => $nom->id,
                            'name' => $nom->name,
                            'description' => $nom->description,
                            'photo' => $nom->photo ? asset('uploads/' . $nom->photo) : null,
                            'votes_count' => $nom->votes_count ?? 0
                        ])->toArray()
                    ]
                ];
            }

            // Slide N+1: Suspense
            $slides[] = [
                'type' => 'suspense',
                'data' => [
                    'category_name' => $category->name
                ]
            ];

            // Calculate winner
            $winner = $this->calculateWinner($category);

            // Slide N+2: Winner
            $slides[] = [
                'type' => 'winner',
                'data' => [
                    'category_name' => $category->name,
                    'category_type' => $category->type->value,
                    'winner' => $winner ? [
                        'id' => $winner->id,
                        'name' => $winner->name,
                        'description' => $winner->description,
                        'photo' => $winner->photo ? asset('uploads/' . $winner->photo) : null,
                        'votes_count' => $winner->votes_count ?? 0
                    ] : null
                ]
            ];
        }

        // Final Slide: Thank You
        $slides[] = [
            'type' => 'thank_you',
            'data' => [
                'award_name' => $award->name,
                'year' => $award->year
            ]
        ];

        return $slides;
    }

    /**
     * Calculate winner based on category type
     *
     * @param \App\Models\Category $category
     * @return \App\Models\Nominee|null
     */
    private function calculateWinner($category)
    {
        if ($category->type === CategoryType::PUBLIC_VOTE) {
            // Winner = Nominee with most votes
            return $category->nominees()
                ->withCount('votes')
                ->orderBy('votes_count', 'desc')
                ->first();
        }

        if ($category->type === CategoryType::ADMIN_CHOICE) {
            // Winner = Category.winner_id
            return $category->winner;
        }

        return null;
    }
}
