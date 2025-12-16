<?php

namespace App\Filament\Resources\Nominees\Pages;

use App\Filament\Resources\Nominees\NomineeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNominees extends ListRecords
{
    protected static string $resource = NomineeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
