<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            ->favicon(asset('heimtech.ico'))


            // 🔥 --- LOGO PERSONALIZADO --- 🔥
            ->brandName('Heimtech')
            ->brandLogo(asset('images/logo-heimtech.png'))
            ->brandLogoHeight('40px')

            // 🎨 --- COLORIMETRÍA HEIMTECH --- 🎨
            ->colors([
                'primary'   => '#2B2BCB',   // Azul eléctrico
                'secondary' => '#1E1E48',   // Azul oscuro
                'success'   => '#47F3C0',   // Turquesa neón
                'info'      => '#47F3C0',   // Info en turquesa
                'warning'   => '#F6C946',   // Amarillo suave
                'danger'    => '#E63946',   // Rojo moderno
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
    // 🟦 Zona 1 – Tarjetas KPI (arriba)
    \App\Filament\Widgets\MonitorStats::class,

    // 🟥 Zona 2 – Hosts caídos (alertas críticas)
    \App\Filament\Widgets\DownHostsWidget::class,

    // 🟩 Zona 3 – Estado general de monitoreo
    \App\Filament\Widgets\MonitorStatusWidget::class,

    // Widgets estándar de Filament (opcionales)
    Widgets\AccountWidget::class,
    Widgets\FilamentInfoWidget::class,
])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
