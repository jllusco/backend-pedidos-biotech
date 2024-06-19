<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'lista_precio_producto';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('lista_precio_id');
        $table->uuid('producto_id');
        $table->decimal('precio_unitario',10,2)->default(0.00);
        $table->foreign('lista_precio_id')->references('id')->on('lista_precio');
        $table->foreign('producto_id')->references('id')->on('producto');
    }
};
