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
        $table->integer('cantidad_entrega_inmediata')->default(0);
        $table->enum('tipo_producto',['CONSUMIBLE','REACTIVO','RUO']);////////////////
        $table->enum('estado',['SOLICITADO','ENTREGADO'])->default('SOLICITADO');
        $table->decimal('precio',10,2);
        $table->decimal('monto',10,2);
        $table->uuid('historial_stock_producto_id')->nullable();
    }
};
