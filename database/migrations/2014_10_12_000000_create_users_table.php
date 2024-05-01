<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends BaseMigration
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->string('name')->unique();
        $table->string('password');
        $table->enum('tipo_documento',['CI','CE'])->default('CI');
        $table->string('numero_documento',15);
        $table->string('nombres',100);
        $table->string('primer_apellido',100)->nullable();
        $table->string('segundo_apellido',100)->nullable();
        $table->string('correo_electronico')->nullable();
        $table->string('celular')->nullable();
        $table->boolean('sistema')->default(false);
        $table->uuid('rol_id');
        $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
        $table->string('institucion',250)->nullable();
        $table->string('departamento',50)->nullable();
        $table->foreign('rol_id')->references('id')->on('rol');
    }
};
