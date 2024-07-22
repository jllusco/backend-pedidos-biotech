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
        $table->string('codigo',50)->nullable();
        $table->uuid('usuario_solicitante_id')->nullable();
        $table->string('nombre_usuario_solicitante')->nullable();
        $table->timestamp('fecha')->nullable();
        $table->decimal('monto_total',10,2)->nullable();
        $table->timestamp('fecha_entrega')->nullable();
        $table->uuid('usuario_atencion_id')->nullable();
        $table->string('nombre_usuario_atencion')->nullable();
        $table->enum('estado',[
            'CREADO',
            'CONFIRMADO',
            'CANCELADO',
            'COMPLETADO',
            'ENTREGADO'
        ])->default('CREADO');
        $table->enum('tipo',['CLIENTE','OPERDAROR'])->default('CLIENTE');
        $table->enum('metodo_pago',['EFECTIVO','TRANSFERENCIA','QR','TARJETA DE CREDITO'])->default('EFECTIVO')->nullable();
        $table->string('ciudad',20)->nullable();
        $table->string('institucion',250)->nullable();
        $table->string('asunto',250)->nullable();
        $table->string('comentario',250)->nullable();
        $table->string('calidad',250)->nullable();
        $table->date('fecha_limite_entrega')->nullable();
        $table->jsonb('contacto')->nullable();
    }
};
