<?php

namespace App\Filament\Resources\MonitorTargetResource\Pages;

use App\Filament\Resources\MonitorTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonitorTargets extends ListRecords
{
    protected static string $resource = MonitorTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
