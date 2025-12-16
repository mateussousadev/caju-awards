<?php

namespace App\Filament\Resources\Nominees\Tables;

use App\CategoryType;
use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NomineesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('uploads')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=N&color=7F9CF5&background=EBF4FF'),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('votes_count')
                    ->label('Votos')
                    ->counts('votes')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->visible(fn ($record) => $record?->category?->type === CategoryType::PUBLIC_VOTE),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->options(
                        Category::query()
                            ->with('award')
                            ->get()
                            ->mapWithKeys(fn ($category) => [
                                $category->id => "{$category->name} ({$category->award->name})"
                            ])
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
