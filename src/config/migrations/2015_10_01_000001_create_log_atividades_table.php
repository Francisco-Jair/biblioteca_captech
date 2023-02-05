<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gestor_id')->unsigned()->nullable();
            $table->foreign('gestor_id')->references('id')->on('gestores')->onDelete('restrict');
            $table->string('function');
            $table->text('url');
            $table->text('request');
            $table->text('method');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_atividades');
    }

}