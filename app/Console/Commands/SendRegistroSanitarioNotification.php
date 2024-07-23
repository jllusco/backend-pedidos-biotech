<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\RegistroSanitarioNotification;
use App\Repository\RegistroSanitarioRepository;
use App\Repository\UserRepositoy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendRegistroSanitarioNotification extends Command
{

    protected $signature = 'notify:registro-sanitario';
    protected $description = 'Verificacion y envio de notificaciones de registros sanitarios por caducar';

    private $registroSanitarioRepository;
    private $userRepository;

    public function __construct(RegistroSanitarioRepository $registroSanitarioRepository, UserRepositoy $userRepositoy)
    {
        parent::__construct();
        $this->registroSanitarioRepository = $registroSanitarioRepository;
        $this->userRepository = $userRepositoy;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $registrosSanitarios = $this->registroSanitarioRepository->findCaducado(30);
        Log::info('Cantidad registros sanitarios por vencer: '.$registrosSanitarios->count());
        $this->info('Cantidad registros sanitarios por vencer: '.$registrosSanitarios->count());
        foreach ($registrosSanitarios as $registro){
            $mensaje = "¡ATENCIÓN! EL REGISTRO SANITARIO CON NÚMERO $registro->numero ESTÁ A 1 MES DE SU VENCIMIENTO. TOMAR EN CUENTA PARA LA RENOVACIÓN";
            $usuarios = $this->userRepository->getUsuariosBiotech();
            /** @var User $user */
            foreach ($usuarios as $user) {
                $user->notify(new RegistroSanitarioNotification($mensaje));
            }
        }
    }
}
