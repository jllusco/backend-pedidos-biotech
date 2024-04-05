<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'registro_sanitario';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('numero',100);
        $table->date('fecha_emision');
        $table->date('fecha_vencimiento');
        $table->text('descripcion')->nullable();
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
