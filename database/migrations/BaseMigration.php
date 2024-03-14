<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 13:56
 */
namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseMigration extends Migration
{
    protected $table;
    protected $softDeletes;

    public function __construct()
    {
        $this->table = '';
        $this->softDeletes = true;
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $this->additionalColumns($table);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            if($this->softDeletes){
                $table->uuid('deleted_by')->nullable();
            }
            $table->timestamps();
            if($this->softDeletes){
                $table->softDeletes();
            }

            /*$table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');*/
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }

    protected function additionalColumns(Blueprint $table)
    {
        // Implementa este método en cada migración hija según sea necesario
    }
}