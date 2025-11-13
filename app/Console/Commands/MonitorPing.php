<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MonitorTarget;
use App\Models\User;
use App\Notifications\HostDownNotification;
use Illuminate\Support\Facades\Log;

class MonitorPing extends Command
{
    protected $signature = 'monitor:ping';
    protected $description = 'Realiza ping a los hosts registrados';

    public function handle()
    {
        foreach (MonitorTarget::all() as $target) {

            // Detectar OS
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $command = "ping -n 1 {$target->host}";
            } else {
                $command = "ping -c 1 -W 1 {$target->host}";
            }

            $output = shell_exec($command);

            // Determinar si está online
            $isOnline =
                str_contains($output, 'TTL=') ||
                str_contains($output, 'ttl=');

            $latency = null;

            // Extraer latencia si está activo
            if ($isOnline) {
                if (preg_match('/time[=<]\s?(\d+\.?\d*)\s?ms/i', $output, $match)) {
                    $latency = (int) $match[1];
                }
            }

            // Estado anterior
            $previous = $target->last_status;

            // Guardar estado actual
            $target->update([
                'is_online' => $isOnline,
                'last_status' => $isOnline,
                'latency' => $latency,
            ]);

            // --- ALERTAS ---
            // Solo si existía estado anterior (evitar alertas en la primera ejecución)
            if ($previous !== null && $previous !== $isOnline) {

                // 📌 Host cayó
                if ($isOnline === false) {
                    Log::warning("⚠ HOST DOWN: {$target->name} ({$target->host})");

                    // Notificar a todos los admins
                    $admins = User::where('role', 'admin')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new HostDownNotification($target));
                    }

                    // (Opcional) Notificación Filament
                    // Filament\Notifications\Notification::make()
                    //     ->title("Host caído: {$target->name}")
                    //     ->danger()
                    //     ->send();
                }

                // 📌 Host volvió a estar online
                if ($isOnline === true) {
                    Log::info("✔ HOST UP: {$target->name} volvió a estar online.");
                }
            }
        }

        return Command::SUCCESS;
    }
}
