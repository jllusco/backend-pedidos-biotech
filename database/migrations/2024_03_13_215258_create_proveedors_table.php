<?php


use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'proveedor';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('nombre',100);
        $table->string('origen',100);
        $table->jsonb('contacto')->default(null)->nullable();
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
    }
};
