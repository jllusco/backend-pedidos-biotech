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
        $table->string('ruta_imagen',200);
        $table->integer('cantidad_actual')->length(4)->default(0);
        $table->decimal('precio_unitario',8,2)->default(0.00);
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
        $table->uuid('categoria_id');
        $table->foreign('categoria_id')->references('id')->on('categoria');
    }
};
