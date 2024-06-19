<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'lista_precio';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('nombre',200);
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
