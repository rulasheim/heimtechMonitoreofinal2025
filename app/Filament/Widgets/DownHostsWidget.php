<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTarget;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class DownHostsWidget extends BaseWidget
{

        
    // 🔄 Auto-refresh cada 5 segundos
    protected static ?string $pollingInterval = '5s';

    protected static ?string $heading = 'Hosts caídos';

    // Ocupa todo el ancho del dashboard (puedes cambiar a 'half' si quieres)
    protected int|string|array $columnSpan = 'full';

    // Solo hosts inactivos
    protected function getTableQuery(): Builder|Relation|null
    {
        return MonitorTarget::query()
            ->where('is_online', false)
            ->orderBy('updated_at', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),

            Tables\Columns\TextColumn::make('host')
                ->label('Host'),

            Tables\Columns\TextColumn::make('latency')
                ->label('Última latencia')
                ->formatStateUsing(fn ($state) =>
                    $state ? "{$state} ms" : 'N/A'
                ),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Último ping')
                ->dateTime('d/m/Y H:i'),
        ];
    }
}
