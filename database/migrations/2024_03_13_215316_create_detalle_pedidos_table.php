<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'detalle_pedido';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('pedido_id');
        $table->enum('estado',['SOLICITADO','EN ESPERA','COMPLETADO','CANCELADO'])->default('SOLICITADO');
    }
};
