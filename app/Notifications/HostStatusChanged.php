<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HostStatusChanged extends Notification
{
    use Queueable;

    protected $host;
    protected $newStatus;

    public function __construct($host, $newStatus)
    {
        $this->host = $host;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusText = $this->newStatus ? 'ONLINE' : 'CAÍDO';

        return (new MailMessage)
            ->subject("Alerta: Host {$this->host->name} está {$statusText}")
            ->line("El host **{$this->host->name}** ({$this->host->host}) ha cambiado a estado **{$statusText}**.")
            ->line('Última latencia: ' . ($this->host->latency ?? 'N/A') . ' ms')
            ->line('Última actualización: ' . $this->host->updated_at)
            ->line('---')
            ->line('Este mensaje se envía solo cuando el host cambia de estado.')
            ->salutation('Sistema de Monitoreo Heimtech');
    }
}
