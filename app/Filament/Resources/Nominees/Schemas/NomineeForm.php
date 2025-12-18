<?php

namespace App\Filament\Resources\Nominees\Schemas;

use App\Models\Category;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NomineeForm
{
    public static function configure(Schema $schema): Schema
    {
        $schema->schema([
            Section::make()
                ->schema([
                    Select::make('category_id')
                        ->label('Categoria')
                        ->options(
                            Category::query()
                                ->with('award')
                                ->get()
                                ->mapWithKeys(fn($category) => [
                                    $category->id => "{$category->name} ({$category->award->name})"
                                ])
                        )
                        ->required()
                        ->searchable()
                        ->preload()
                        ->columnSpanFull(),

                    Select::make('user_id')
                        ->label('Usuário (opcional)')
                        ->options(User::query()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->helperText('Vincule este indicado a um usuário do sistema, caso aplicável.'),

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

                    FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->disk('uploads')
                        ->directory('nominees')
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                        ->maxSize(2048) // 2MB
                        ->imagePreviewHeight('250')
                        ->imageEditor()
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);

        return $schema;
    }
}
