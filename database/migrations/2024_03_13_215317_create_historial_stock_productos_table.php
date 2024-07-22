<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'historial_stock_producto';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('producto_id');
        $table->enum('tipo',['INGRESO','EGRESO']);
        $table->integer('cantidad');
        $table->text('descripcion');
        $table->uuid('detalle_pedido_id')->nullable();
        $table->foreign('producto_id')->references('id')->on('producto');
        $table->foreign('detalle_pedido_id')->references('id')->on('detalle_pedido');
    }
};
