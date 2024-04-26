<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'historial_estado_pedido';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('pedido_id');
        $table->enum('estado',['CREADO','SOLICITADO','EN CURSO','PENDIENTE','CONFIRMADO','COMPLETADO','CANCELADO'])->default('CREADO');
        $table->string('nombre_usuario');
        $table->string('rol_usuario');
    }
};
