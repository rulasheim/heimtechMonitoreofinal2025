<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HostDownNotification extends Notification
{
    use Queueable;

    public $target;

    public function __construct($target)
    {
        $this->target = $target;
    }

    public function via($notifiable)
    {
        return ['mail']; // email (puedes agregar "database")
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("⚠ ALARMA: Host inalcanzable ({$this->target->name})")
            ->line("El host **{$this->target->name}** ({$this->target->host}) está INALCANZABLE.")
            ->line("Revisar la conectividad o dispositivo.")
            ->line("Última latencia registrada: {$this->target->latency} ms")
            ->line('Sistema de Monitoreo Heimtech');
    }
}
