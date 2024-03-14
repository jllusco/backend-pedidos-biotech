<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'rol';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('codigo',50);
        $table->string('nombre',100);
        $table->text('descripcion');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }

};
