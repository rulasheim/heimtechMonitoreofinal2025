<?php

namespace App\Filament\Resources\MonitorTargetResource\Pages;

use App\Filament\Resources\MonitorTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonitorTarget extends EditRecord
{
    protected static string $resource = MonitorTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
