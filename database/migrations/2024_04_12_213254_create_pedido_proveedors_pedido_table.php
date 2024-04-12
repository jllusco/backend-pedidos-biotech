<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pedido_proveedor_pedido';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('pedido_id');
        $table->uuid('pedido_proveedor_id');
        $table->foreign('pedido_id')->references('id')->on('pedido');
        $table->foreign('pedido_proveedor_id')->references('id')->on('pedido_proveedor');

    }
};
