<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'cronograma';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->smallInteger('mes');
        $table->string('nombre','10');
        $table->smallInteger('inicio');
        $table->smallInteger('fin');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
