<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pedido';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('codigo',50);
        $table->uuid('usuario_solicitante_id');
        $table->timestamp('fecha')->useCurrent();
        $table->decimal('monto_total',8,2);
        $table->timestamp('fecha_entrega')->useCurrent()->nullable();
        $table->uuid('usuario_entrega_id')->nullable();
        $table->enum('estado',['CREADO','SOLICITADO','EN ESPERA','COMPLETADO','CANCELADO'])->default('CREADO');
        $table->enum('tipo',['CLIENTE','OPERDAROR'])->default('CLIENTE');
        $table->enum('sub_tipo',['REACTIVO','REACTIVOS RUO','CONSUMIBLES'])->nullable();
        $table->enum('metodo_pago',['EFECTIVO','TRANSFERENCIA','QR','TARJETA DE CREDITO'])->default('EFECTIVO')->nullable();
    }
};
