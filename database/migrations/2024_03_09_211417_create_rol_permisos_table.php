<?php

use Database\Migrations\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'rol_permiso';
    }

    protected function additionalColumns(Blueprint $table)
    {
        $table->uuid('rol_id');
        $table->uuid('permiso_id');
        $table->foreign('rol_id')->references('id')->on('rol');
        $table->foreign('permiso_id')->references('id')->on('permiso');

    }
};
