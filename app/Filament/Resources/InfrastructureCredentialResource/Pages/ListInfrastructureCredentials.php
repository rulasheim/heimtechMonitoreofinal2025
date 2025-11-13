<?php

namespace App\Filament\Resources\InfrastructureCredentialResource\Pages;

use App\Filament\Resources\InfrastructureCredentialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfrastructureCredentials extends ListRecords
{
    protected static string $resource = InfrastructureCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
