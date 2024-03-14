<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'menu';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('nombre');
        $table->string('ruta');
        $table->string('icono');
        $table->smallInteger('orden');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
