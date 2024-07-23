<?php

namespace App\Console\Commands;

use App\Models\Cronograma;
use App\Models\User;
use App\Notifications\PedidoPendienteNotification;
use App\Repository\PedidoRepository;
use App\Repository\UserRepositoy;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPedidoPendienteNotification extends Command
{
    protected $signature = 'notify:pedidos-pendientes';
    protected $description = 'Verificacion y envio de notificaciones de registros sanitarios por caducar';

    private $pedidoRepository;
    private $userRepository;


    public function __construct(PedidoRepository $pedidoRepository, UserRepositoy $userRepositoy)
    {
        parent::__construct();
        $this->pedidoRepository = $pedidoRepository;
        $this->userRepository = $userRepositoy;
    }


    public function handle()
    {
        $fechaActual = (Carbon::now())->setTime(0,0,0,0);
        $cronogramaActual = Cronograma::query()->where('mes','=',intval($fechaActual->format('m')))->where('estado','=','ACTIVO')->first();
        if($cronogramaActual){
            $fechaFin = Carbon::create($fechaActual->format('Y'),$cronogramaActual->mes,$cronogramaActual->fin);
            $diasRestantes = $fechaFin->diffInDays($fechaActual);
            if($diasRestantes>=0 and $diasRestantes<=3){
                $diasRestantes = $diasRestantes === 0?"HOY":"EN $diasRestantes DÍAS";
                $pedidosPendientes = $this->pedidoRepository->getPedidosPendientes();
                $this->info('Cantidad pedidos pendientes : '.$pedidosPendientes->count());
                foreach ($pedidosPendientes as $pedido){
                    $mensaje = "¡ATENCIÓN! $diasRestantes TERMINA EL PERÍODO DE ACEPTACIÓN DE PEDIDOS. EL PEDIDO DEL CLIENTE $pedido->nombre_usuario_solicitante SE ENCUENTRA EN ESTADO CREADO";
                    $usuarios = $this->userRepository->getUsuariosAlmacen();
                    foreach ($usuarios as $user) {
                        $user->notify(new PedidoPendienteNotification($mensaje));
                    }
                    $usuarioCreador = User::find($pedido->usuario_solicitante_id);
                    $mensaje = "¡ATENCIÓN! $diasRestantes TERMINA EL PERÍODO DE ACEPTACIÓN DE PEDIDOS. ACTUALMENTE TIENE UN PEDIDO EN ESTADO CREADO, POR FAVOR CONFIRMAR PARA ENVIAR A ALMACÉN Y ASÍ PROCEDER CON LA PREPARACIÓN DE SU PEDIDO CORRESPONDIENTEMENTE";
                    $usuarioCreador->notify(new PedidoPendienteNotification($mensaje));
                }
            }
        }
    }
}
