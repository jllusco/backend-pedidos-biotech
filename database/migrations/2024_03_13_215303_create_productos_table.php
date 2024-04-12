<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'producto';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('codigo',50);
        $table->string('nombre',100);
        $table->text('descripcion');
        $table->string('ruta_imagen',200)->default('image/productos/product-default.png');
        $table->integer('cantidad_actual')->length(4)->default(0);
        $table->decimal('precio_unitario',8,2)->default(0.00);
        $table->decimal('precio_exwork',8,2)->default(0.00);
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
        $table->enum('unidad',['CAJA','FRASCO','KIT','UNIDAD'])->default('UNIDAD');
        $table->enum('tipo',['CONSUMIBLE','REACTIVO','RUO']);
        $table->jsonb('temperatura')->nullable()->default(null);
        $table->boolean('oferta')->default(false);
        $table->uuid('categoria_id')->nullable();
        $table->uuid('proveedor_id')->nullable();
        $table->uuid('registro_sanitario_id')->nullable();
        $table->uuid('presentacion_id')->nullable();
        $table->foreign('categoria_id')->references('id')->on('categoria');
        $table->foreign('proveedor_id')->references('id')->on('proveedor');
        $table->foreign('registro_sanitario_id')->references('id')->on('registro_sanitario');
        $table->foreign('presentacion_id')->references('id')->on('parametro');
    }
};
