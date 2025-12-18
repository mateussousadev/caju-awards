<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Nominee;
use Illuminate\Database\Seeder;

class NomineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Nenhuma categoria encontrada. Execute CategorySeeder primeiro.');
            return;
        }

        // Categoria: Suporte Destaque - Embaixador da Eficiência e Cliente
        $suporteDestaque = $categories->where('name', 'Suporte Destaque - Embaixador da Eficiência e Cliente')->first();
        if ($suporteDestaque) {
            Nominee::create([
                'category_id' => $suporteDestaque->id,
                'name' => 'Alex Victor',
                'description' => 'Líder de Suporte',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $suporteDestaque->id,
                'name' => 'Kauã Duarte',
                'description' => 'Estagiário',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $suporteDestaque->id,
                'name' => 'Clailton da Costa',
                'description' => 'Estagiário',
                'photo' => null,
            ]);
        }

        // Categoria: Dev Inovador - Mestre da Inovação e Qualidade
        $devInovador = $categories->where('name', 'Dev Inovador - Mestre da Inovação e Qualidade')->first();
        if ($devInovador) {
            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Lucas Lima',
                'description' => 'Desenvolvedor Mobile',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Mikely Souza',
                'description' => 'Tech Lead',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Reginaldo Junior',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Eduardo Frota',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Izaías de Castro',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Antonio Neto',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $devInovador->id,
                'name' => 'Mateus Sousa',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);
        }

        // Categoria: QA do Ano
        $qaDoAno = $categories->where('name', 'QA do Ano')->first();
        if ($qaDoAno) {
            Nominee::create([
                'category_id' => $qaDoAno->id,
                'name' => 'Anne Karoline',
                'description' => 'Estagiária',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $qaDoAno->id,
                'name' => 'Liam Hoffman',
                'description' => 'QA Jr',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $qaDoAno->id,
                'name' => 'Hilton Rocha',
                'description' => 'Líder QA',
                'photo' => null,
            ]);
        }

        // Categoria: Solucionador do Ano (The Problem Solver) - TODOS
        $solucionador = $categories->where('name', 'Solucionador do Ano (The Problem Solver)')->first();
        if ($solucionador) {
            // Time Suporte
            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Alex Victor',
                'description' => 'Líder de Suporte',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Kauã Duarte',
                'description' => 'Estagiário',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Clailton da Costa',
                'description' => 'Estagiário',
                'photo' => null,
            ]);

            // Time Financeiro
            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Fabíola',
                'description' => 'Líder do Financeiro',
                'photo' => null,
            ]);

            // Time QA
            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Anne Karoline',
                'description' => 'Estagiária',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Liam Hoffman',
                'description' => 'QA Jr',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Hilton Rocha',
                'description' => 'Líder QA',
                'photo' => null,
            ]);

            // Time Mobile
            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Lucas Lima',
                'description' => 'Desenvolvedor Mobile',
                'photo' => null,
            ]);

            // Time Desenvolvimento
            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Mikely Souza',
                'description' => 'Tech Lead',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Reginaldo Junior',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Eduardo Frota',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Izaías de Castro',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Antonio Neto',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $solucionador->id,
                'name' => 'Mateus Sousa',
                'description' => 'Desenvolvedor Fullstack',
                'photo' => null,
            ]);
        }
    }
}
