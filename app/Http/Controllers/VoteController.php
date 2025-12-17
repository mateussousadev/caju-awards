<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Nominee;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created vote in storage.
     */
    public function store(Request $request, $award_id)
    {
        // Verificar autenticação
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado para votar.'
            ], 401);
        }

        // Validar dados
        $validated = $request->validate([
            'nominee_id' => 'required|exists:nominees,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user = Auth::user();
        $nomineeId = $validated['nominee_id'];
        $categoryId = $validated['category_id'];

        // Validação 1: Category pertence ao award
        $category = Category::where('id', $categoryId)
            ->where('award_id', $award_id)
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não pertence a esta premiação.'
            ], 422);
        }

        // Validação 2: Nominee pertence à category
        $nominee = Nominee::where('id', $nomineeId)
            ->where('category_id', $categoryId)
            ->first();

        if (!$nominee) {
            return response()->json([
                'success' => false,
                'message' => 'Indicado não pertence a esta categoria.'
            ], 422);
        }

        // Validação 3: Usuário já votou nesta categoria
        $existingVote = Vote::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->first();

        if ($existingVote) {
            return response()->json([
                'success' => false,
                'message' => 'Você já votou nesta categoria.',
                'voted_nominee_id' => $existingVote->nominee_id
            ], 422);
        }

        // Salvar voto
        try {
            Vote::create([
                'user_id' => $user->id,
                'category_id' => $categoryId,
                'nominee_id' => $nomineeId,
                'ip_address' => $request->ip(),
            ]);

            // Atualizar quantitative_value com COUNT de votos
            $voteCount = Vote::where('nominee_id', $nomineeId)->count();
            $nominee->update(['quantitative_value' => $voteCount]);

            return response()->json([
                'success' => true,
                'message' => 'Voto registrado com sucesso!',
                'vote_count' => $voteCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar voto. Tente novamente.'
            ], 500);
        }
    }

    /**
     * Remove the user's vote from a category.
     */
    public function destroy(Request $request, $award_id)
    {
        // Verificar autenticação
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado.'
            ], 401);
        }

        // Validar dados
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $user = Auth::user();
        $categoryId = $validated['category_id'];

        // Validação: Category pertence ao award
        $category = Category::where('id', $categoryId)
            ->where('award_id', $award_id)
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não pertence a esta premiação.'
            ], 422);
        }

        // Buscar voto existente
        $existingVote = Vote::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->first();

        if (!$existingVote) {
            return response()->json([
                'success' => false,
                'message' => 'Você não votou nesta categoria.'
            ], 422);
        }

        // Deletar voto
        try {
            $nomineeId = $existingVote->nominee_id;
            $existingVote->delete();

            // Atualizar quantitative_value com COUNT de votos
            $nominee = Nominee::find($nomineeId);
            if ($nominee) {
                $voteCount = Vote::where('nominee_id', $nomineeId)->count();
                $nominee->update(['quantitative_value' => $voteCount]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Voto removido com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover voto. Tente novamente.'
            ], 500);
        }
    }
}
