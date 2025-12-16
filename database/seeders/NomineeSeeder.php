<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Nominee;
use App\Models\User;
use Illuminate\Database\Seeder;

class NomineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::where('is_admin', false)->get();

        if ($categories->isEmpty()) {
            $this->command->error('Nenhuma categoria encontrada. Execute CategorySeeder primeiro.');
            return;
        }

        if ($users->count() < 3) {
            $this->command->error('Não há usuários suficientes. Execute UserSeeder primeiro.');
            return;
        }

        // Categoria: Melhor Programador
        $melhorProgramador = $categories->where('name', 'Melhor Programador')->first();
        if ($melhorProgramador) {
            Nominee::create([
                'category_id' => $melhorProgramador->id,
                'user_id' => $users[0]->id,
                'name' => $users[0]->name,
                'description' => 'Desenvolvedor full-stack com expertise em Laravel e React. Contribuiu com otimizações significativas no sistema.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorProgramador->id,
                'user_id' => $users[1]->id,
                'name' => $users[1]->name,
                'description' => 'Especialista em arquitetura de software. Liderou a refatoração do core da aplicação.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorProgramador->id,
                'user_id' => $users[2]->id,
                'name' => $users[2]->name,
                'description' => 'Expert em DevOps e automação. Implementou CI/CD que reduziu o tempo de deploy em 70%.',
                'photo' => null,
            ]);
        }

        // Categoria: Melhor Projeto do Ano
        $melhorProjeto = $categories->where('name', 'Melhor Projeto do Ano')->first();
        if ($melhorProjeto) {
            Nominee::create([
                'category_id' => $melhorProjeto->id,
                'user_id' => $users[0]->id,
                'name' => 'Sistema de Gestão Integrada',
                'description' => 'Plataforma completa para gestão de processos internos, integrando 5 departamentos diferentes.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorProjeto->id,
                'user_id' => $users[1]->id,
                'name' => 'App Mobile de Atendimento',
                'description' => 'Aplicativo que revolucionou o atendimento ao cliente com recursos de IA.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorProjeto->id,
                'user_id' => $users[3]->id,
                'name' => 'Portal de Analytics',
                'description' => 'Dashboard em tempo real para visualização de KPIs e métricas de negócio.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorProjeto->id,
                'user_id' => $users[4]->id,
                'name' => 'API Gateway Corporativa',
                'description' => 'Gateway centralizado que unificou todas as APIs da empresa.',
                'photo' => null,
            ]);
        }

        // Categoria: Melhor Líder
        $melhorLider = $categories->where('name', 'Melhor Líder')->first();
        if ($melhorLider) {
            Nominee::create([
                'category_id' => $melhorLider->id,
                'user_id' => $users[2]->id,
                'name' => $users[2]->name,
                'description' => 'Tech Lead que desenvolveu 3 novos desenvolvedores júniors em seniores.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorLider->id,
                'user_id' => $users[3]->id,
                'name' => $users[3]->name,
                'description' => 'Gerente de projetos que entregou 100% dos projetos no prazo e com qualidade.',
                'photo' => null,
            ]);

            Nominee::create([
                'category_id' => $melhorLider->id,
                'user_id' => $users[4]->id,
                'name' => $users[4]->name,
                'description' => 'CTO que implementou cultura de inovação e melhorou o NPS do time técnico.',
                'photo' => null,
            ]);
        }
    }
}
