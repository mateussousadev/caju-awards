<?php

namespace App\Filament\Resources\Categories\Tables;

use App\CategoryType;
use App\Models\Award;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('award.name')
                    ->label('Premiação')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (CategoryType $state): string => match ($state) {
                        CategoryType::PUBLIC_VOTE => 'info',
                        CategoryType::ADMIN_CHOICE => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (CategoryType $state): string => match ($state) {
                        CategoryType::PUBLIC_VOTE => 'Votação Pública',
                        CategoryType::ADMIN_CHOICE => 'Escolha do Admin',
                        default => $state->value,
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('award_id')
                    ->label('Premiação')
                    ->options(
                        Award::query()
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        CategoryType::PUBLIC_VOTE->value => 'Votação Pública',
                        CategoryType::ADMIN_CHOICE->value => 'Escolha do Admin',
                    ]),
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
