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
        $table->uuid('producto_id');
        $table->integer('cantidad');
        $table->decimal('precio',8,2);
        $table->decimal('monto',8,2);
    }
};
