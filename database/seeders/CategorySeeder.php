<?php

namespace Database\Seeders;

use App\CategoryType;
use App\Models\Award;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $award = Award::first();

        if (!$award) {
            $this->command->error('Nenhuma premiação encontrada. Execute AwardSeeder primeiro.');
            return;
        }

        // Categorias de voto público
        Category::create([
            'award_id' => $award->id,
            'name' => 'Melhor Programador',
            'description' => 'Programador que mais se destacou durante o ano com suas contribuições técnicas e inovações.',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 1,
        ]);

        Category::create([
            'award_id' => $award->id,
            'name' => 'Melhor Projeto do Ano',
            'description' => 'Projeto que teve maior impacto e qualidade de entrega no ano.',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 2,
        ]);

        // Categoria de escolha admin
        Category::create([
            'award_id' => $award->id,
            'name' => 'Melhor Líder',
            'description' => 'Líder que mais inspirou e desenvolveu seu time durante o ano.',
            'type' => CategoryType::ADMIN_CHOICE,
            'public_vote_weight' => 0,
            'quantitative_weight' => 0,
            'jury_weight' => 100,
            'order' => 3,
        ]);
    }
}
