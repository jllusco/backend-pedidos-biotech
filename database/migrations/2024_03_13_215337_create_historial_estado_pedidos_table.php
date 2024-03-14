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
        $table->decimal('precio_unitario',8,2);
        $table->integer('cantidad')->length(4);
        $table->decimal('monto',8,2);
    }
};
