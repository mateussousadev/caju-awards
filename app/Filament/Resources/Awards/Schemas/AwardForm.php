<?php

namespace App\Filament\Resources\Awards\Schemas;

use App\AwardStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AwardForm
{
    public static function configure(Schema $schema): Schema
    {
        $schema->schema([
            Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('year')
                        ->label('Ano')
                        ->required()
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(2100)
                        ->default(date('Y')),

                    Select::make('status')
                        ->label('Status')
                        ->options(AwardStatus::class)
                        ->required()
                        ->default(AwardStatus::DRAFT),

                    DatePicker::make('voting_start_date')
                        ->label('Data de Início da Votação')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    DatePicker::make('voting_end_date')
                        ->label('Data de Fim da Votação')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->after('voting_start_date'),
                ])
                ->columns(2),
        ]);

        return $schema;
    }
}
