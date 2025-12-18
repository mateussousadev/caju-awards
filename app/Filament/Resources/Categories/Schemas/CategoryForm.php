<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\CategoryType;
use App\Models\Award;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        $schema->schema([
            Section::make()
                ->schema([
                    Select::make('award_id')
                        ->label('Premiação')
                        ->options(
                            Award::query()
                                ->where('is_active', true)
                                ->pluck('name', 'id')
                        )
                        ->required()
                        ->searchable()
                        ->preload(),

                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Descrição')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    Radio::make('type')
                        ->label('Tipo')
                        ->options([
                            CategoryType::PUBLIC_VOTE->value => 'Votação Pública',
                            CategoryType::ADMIN_CHOICE->value => 'Escolha Direta do Admin',
                        ])
                        ->required()
                        ->default(CategoryType::PUBLIC_VOTE->value)
                        ->inline()
                        ->live()
                        ->columnSpanFull(),

                    Select::make('winner_id')
                        ->label('Vencedor')
                        ->relationship(
                            name: 'winner',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query, Get $get) => $query->where('category_id', $get('id'))
                        )
                        ->searchable()
                        ->preload()
                        ->visible(fn (Get $get) => $get('type') === CategoryType::ADMIN_CHOICE->value)
                        ->disabled(fn ($record) => $record === null)
                        ->helperText(fn ($record) => $record === null
                            ? 'Salve a categoria primeiro para poder selecionar o vencedor.'
                            : null
                        )
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);

        return $schema;
    }
}
