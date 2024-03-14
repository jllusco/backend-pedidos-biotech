<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'parametro';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('grupo',100);
        $table->string('codigo',50);
        $table->string('nombre',100);
        $table->text('descripcion');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
        $table->boolean('sistema')->default(false);
    }
};
