<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTarget;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class MonitorStatusWidget extends BaseWidget
{
    protected static ?int $pollingInterval = 5; // refresca cada 5 segundos

    protected static ?string $heading = 'Estado de Monitoreo';

    protected int|string|array $columnSpan = 'full';

    public function getTableQuery(): Builder
    {
        return MonitorTarget::query()->orderBy('is_online', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),

            Tables\Columns\TextColumn::make('host')
                ->label('Host')
                ->searchable(),

            Tables\Columns\IconColumn::make('is_online')
                ->label('Estado')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger'),

            Tables\Columns\TextColumn::make('latency')
                ->label('Latencia')
                ->formatStateUsing(fn ($state) =>
                    $state ? "{$state} ms" : 'N/A'
                ),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Último Ping')
                ->dateTime('d/m/Y H:i'),
        ];
    }
}
