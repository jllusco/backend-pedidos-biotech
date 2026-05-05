<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\PedidoRealizadoNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationPedidoRealizadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tipo;
    protected $idUsuario;
    protected $idPedido;

    /**
     * Create a new job instance.
     */
    public function __construct($tipo,$idUsuario,$idPedido)
    {
        $this->tipo = $tipo;
        $this->idUsuario = $idUsuario;
        $this->idPedido = $idPedido;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            /** @var User $usuarioCreador */
            $usuarioCreador = User::find($this->idUsuario);

            $mensajesCreador = [
                'CONFIRMADO' => 'MUCHAS GRACIAS POR REALIZAR SU PEDIDO',
                'CANCELADO' => 'POR FAVOR ESCRÍBANOS Y DÉJENOS SABER EL MOTIVO POR EL CUAL CANCELÓ EL PEDIDO. SU OPINIÓN ES MUY IMPORTANTE PARA NOSOTROS'
            ];

            $mensajes = [
                'CONFIRMADO' => "EL CLIENTE $usuarioCreador->nombres HA REALIZADO LA CONFIRMACIÓN DE SU ÚLTIMO PEDIDO. REVISAR EN LA PLATAFORMA PARA RECEPCIONARLO",
                'CANCELADO' => "EL CLIENTE $usuarioCreador->nombres HA CANCELADO SU ÚLTIMO PEDIDO, TOMAR EN CUENTA REVISANDO EN LA PLATAFORMA PARA NO INCLUIR EN EL PIAL"
            ];

            $roles = [config('constants.ROL_ADMINISTRADOR'), config('constants.ROL_ALMACEN')];

            $usuarios = User::whereIn('rol_id',$roles)
                ->where('estado', '=', 'ACTIVO')
                ->get();

            /** @var User $user */
            foreach ($usuarios as $user) {
                $user->notify(new PedidoRealizadoNotification($mensajes[$this->tipo]));
            }

            $usuarioCreador->notify(new PedidoRealizadoNotification($mensajesCreador[$this->tipo]));
        }catch(\Exception $e){
            Log::info('Error: '.$e);
        }
    }
}
