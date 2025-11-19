<?php

namespace App\Filament\Widgets;

use App\Models\MonitorTarget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonitorStats extends BaseWidget
{
    // 🔥 Auto-refresh cada 5 segundos (tipo correcto: ?string)
    protected static ?string $pollingInterval = '5s';
    
    protected function getStats(): array
    {
        $total = MonitorTarget::count();
        $online = MonitorTarget::where('is_online', true)->count();
        $offline = MonitorTarget::where('is_online', false)->count();

        return [
            Stat::make('Hosts registrados', $total)
                ->description('Total de dispositivos monitoreados')
                ->descriptionIcon('heroicon-o-server-stack')
                ->color('primary'),

            Stat::make('Hosts activos', $online)
                ->description('Respondiendo a ping')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Hosts caídos', $offline)
                ->description('Sin respuesta')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
