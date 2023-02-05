<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_login', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gestor_id')->unsigned();
            $table->foreign('gestor_id')->references('id')->on('gestores')->onDelete('restrict');
            $table->string('hash');
            $table->datetime('data_entrada');
            $table->datetime('data_saida')->nullable();
            $table->string('tempo_conexao')->nullable();
            $table->string('ip');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_login');
    }

}