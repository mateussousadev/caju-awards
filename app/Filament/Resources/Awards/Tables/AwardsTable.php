<?php

namespace App\Filament\Resources\Awards\Tables;

use App\CategoryType;
use Filament\Actions\Action;
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

                TextColumn::make('year')
                    ->label('Ano')
                    ->sortable()
                    ->searchable(),

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
                Action::make('presentation')
                    ->label('Iniciar Apresentação')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->color('success')
                    ->url(fn ($record) => route('presentation.show', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) =>
                        $record->categories()
                            ->whereIn('type', [CategoryType::PUBLIC_VOTE, CategoryType::ADMIN_CHOICE])
                            ->exists()
                    ),
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