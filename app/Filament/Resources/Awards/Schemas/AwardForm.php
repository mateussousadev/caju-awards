<?php

namespace App\Filament\Resources\Awards\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

                    Textarea::make('description')
                        ->label('Descrição')
                        ->rows(3)
                        ->columnSpanFull(),

                    DateTimePicker::make('voting_start_at')
                        ->label('Início da Votação')
                        ->native(false)
                        ->displayFormat('d/m/Y H:i')
                        ->seconds(false),

                    DateTimePicker::make('voting_end_at')
                        ->label('Fim da Votação')
                        ->native(false)
                        ->displayFormat('d/m/Y H:i')
                        ->seconds(false)
                        ->after('voting_start_at')
                        ->rule('after:voting_start_at'),

                    Toggle::make('is_active')
                        ->label('Ativo')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),
        ]);

        return $schema;
    }
}
