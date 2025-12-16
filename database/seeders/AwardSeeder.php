<?php

namespace Database\Seeders;

use App\AwardStatus;
use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Award::create([
            'name' => 'Cajutec Awards 2025',
            'description' => 'Premiação anual para reconhecer os melhores profissionais e projetos da Cajutec.',
            'year' => 2025,
            'voting_start_at' => now(),
            'voting_end_at' => now()->addDays(30),
            'status' => AwardStatus::VOTING,
            'is_active' => true,
        ]);
    }
}
