<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comunicado_usuario', function (Blueprint $table) {
            $table->uuid('comunicado_id');
            $table->uuid('usuario_id');
            $table->unique(['comunicado_id', 'usuario_id']);
            $table->foreign('comunicado_id')
                ->references('id')
                ->on('comunicado')
                ->onDelete('cascade');
            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comunicado_usuario');
    }
};
