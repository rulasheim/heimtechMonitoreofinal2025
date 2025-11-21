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
    $emails = [
        'raul.padilla@heimtech.mx',
        'correo2@example.com',
        'correo3@example.com',
    ];

    foreach (MonitorTarget::all() as $target) {
        
        // Detectar OS
        $command = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? "ping -n 1 {$target->host}"
            : "ping -c 1 -W 1 {$target->host}";

        $output = shell_exec($command);

        $isOnline =
            str_contains($output, 'TTL=') ||
            str_contains($output, 'ttl=');

        $latency = null;
        if ($isOnline && preg_match('/time[=<]\s?(\d+\.?\d*)\s?ms/i', $output, $match)) {
            $latency = (int) $match[1];
        }

        // Detectar cambio de estado
        $stateChanged = $target->last_status !== $isOnline;

        // Guardar estado
        $target->update([
            'last_status' => $isOnline,
            'is_online' => $isOnline,
            'latency' => $latency,
        ]);

        // Enviar notificación solo si cambió de estado
        if ($stateChanged) {
            foreach ($emails as $email) {
                \Illuminate\Support\Facades\Notification::route('mail', $email)
                    ->notify(new \App\Notifications\HostStatusChanged($target, $isOnline));
            }
        }
    }

    return Command::SUCCESS;
}

}
