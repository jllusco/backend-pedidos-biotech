<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pedido_proveedor';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('codigo',50);
        $table->uuid('usuario_solicitante_id')->nullable();
        $table->string('nombre_usuario_solicitante')->nullable();
        $table->timestamp('fecha')->nullable();
        $table->enum('tipo',['CONSUMIBLE','REACTIVO','RUO']);
        $table->string('asunto',250)->nullable();
        $table->string('comentario',250)->nullable();
        $table->decimal('monto_total',8,2)->nullable();
        $table->uuid('proveedor_id');
        $table->enum('moneda',['DOLARES','BOLIVIANOS'])->default('DOLARES');
    }
};
