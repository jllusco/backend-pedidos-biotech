<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
     public function __construct()
    {
        parent::__construct();
        $this->table = 'comunicado';
    }

    protected function additionalColumns(Blueprint $table) {
        $table->string('titulo','250');
        $table->text('descripcion');
        $table->string('imagen','200')->nullable();
        $table->string('documento','200')->nullable();
        $table->enum('tipo',['TEXTO','IMAGEN','MORA_PAGO'])->default('TEXTO');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
        $table->enum('audiencia',['GLOBAL','USUARIO'])->default('GLOBAL');
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_fin')->nullable();
    }
};

