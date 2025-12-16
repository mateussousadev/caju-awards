<?php

namespace App\Filament\Resources\Awards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AwardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('voting_start_at')
                    ->label('Início da Votação')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('voting_end_at')
                    ->label('Fim da Votação')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),
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
            ->defaultSort('voting_start_at', 'desc');
    }
}