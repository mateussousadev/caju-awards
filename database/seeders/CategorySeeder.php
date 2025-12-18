<?php

namespace Database\Seeders;

use App\CategoryType;
use App\Models\Award;
use App\Models\Category;
use App\Models\Nominee;
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
            'name' => 'Suporte Destaque - Embaixador da Eficiência e Cliente',
            'description' => 'Para o profissional de Suporte que combinou paciência e excelência no atendimento ao cliente (resolvendo problemas e dando retornos satisfatórios) com a criação de documentação/protocolos claros que comprovadamente reduziram o tempo de resolução para o cliente e para os times internos (Dev/QA).',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 1,
        ]);

        Category::create([
            'award_id' => $award->id,
            'name' => 'Dev Inovador - Mestre da Inovação e Qualidade',
            'description' => 'Para o desenvolvedor que não apenas implementou a solução técnica mais criativa e inovadora, mas que o fez com código limpo, padronizado e seguindo as melhores práticas.',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 2,
        ]);

        Category::create([
            'award_id' => $award->id,
            'name' => 'QA do Ano',
            'description' => 'Esta categoria reconhece o profissional de Quality Assurance (QA) que demonstrou excelência excepcional na garantia da qualidade de produtos e serviços ao longo do ano. Com um foco implacável na detecção precoce de falhas, bugs e inconsistências, o vencedor se destaca por implementar estratégias inovadoras de teste que elevam os padrões de confiabilidade e performance.',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 3,
        ]);

        Category::create([
            'award_id' => $award->id,
            'name' => 'Solucionador do Ano (The Problem Solver)',
            'description' => 'Reconhece o profissional que, através de inovação, código elegante, automação ou colaboração intersetorial, entregou a solução mais impactante e visível, seja em um protocolo complexo, na criação de uma nova ideia ou na melhoria de um processo crítico.',
            'type' => CategoryType::PUBLIC_VOTE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 4,
        ]);

        // Criar categoria Funcionário do Ano e seu nominee vencedor
        $funcionarioDoAno = Category::create([
            'award_id' => $award->id,
            'name' => 'Funcionário do Ano (fabs)',
            'description' => 'Melhor profissional de todas.',
            'type' => CategoryType::ADMIN_CHOICE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 5,
        ]);

        $fabiola = Nominee::create([
            'category_id' => $funcionarioDoAno->id,
            'name' => 'Fabíola Leite',
            'description' => 'Líder do Financeiro',
            'photo' => null,
        ]);

        $funcionarioDoAno->update(['winner_id' => $fabiola->id]);

        // Criar categoria Paitrocínio e seu nominee vencedor
        $paitrocinio = Category::create([
            'award_id' => $award->id,
            'name' => 'Paitrocínio',
            'description' => 'Melhor pessoa de todas.',
            'type' => CategoryType::ADMIN_CHOICE,
            'public_vote_weight' => 100,
            'quantitative_weight' => 0,
            'jury_weight' => 0,
            'order' => 6,
        ]);

        $raimundo = Nominee::create([
            'category_id' => $paitrocinio->id,
            'name' => 'Raimundo Machado',
            'description' => 'Sócio',
            'photo' => null,
        ]);

        $paitrocinio->update(['winner_id' => $raimundo->id]);
    }
}
