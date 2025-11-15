<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // 🔥 Recarga TODO el Dashboard cada 5 segundos
    protected static ?string $pollingInterval = '5s';

    // Icono del menú (opcional)
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
}
