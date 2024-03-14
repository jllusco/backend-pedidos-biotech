<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = 'categoria';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('codigo',50);
        $table->string('nombre',150);
        $table->string('descripcion',300);
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
