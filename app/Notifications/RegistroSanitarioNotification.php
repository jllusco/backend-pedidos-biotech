<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistroSanitarioNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo'=>'REGISTRO SANITARIO',
            'message' => $this->message,
            'ruta'=>'/app/registros-sanitarios'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Registro sanitario')
            ->greeting('Alerta!')
            ->line($this->message)
            ->action('Ver registro', env('APP_FRONTEND_URL').'/app/registros-sanitarios' )
            ->line('Gracias por usar nuestra aplicación!')
            ->salutation('Saludos, El equipo de Biotech');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'titulo'=>'REGISTRO SANITARIO',
            'message' => $this->message,
            'ruta'=>'/app/registros-sanitarios'
        ];
    }
}
