<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoPendienteNotification extends Notification
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
            'titulo'=>'PEDIDO CREADO',
            'message' => $this->message,
            'ruta'=>'/app/pedidos'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pedido pendiente')
            ->greeting('¡Hola!')
            ->line($this->message)
            ->action('Ver Pedido', url('/'))
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
            'titulo'=>'PEDIDO CREADO',
            'message' => $this->message,
            'ruta'=>'/app/pedidos'
        ];
    }
}
