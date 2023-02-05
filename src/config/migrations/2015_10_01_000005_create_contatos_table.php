<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assunto_id')->unsigned()->nullable();
            $table->foreign('assunto_id')->references('id')->on('assuntos')->onDelete('restrict');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->text('mensagem');
            $table->string('ip');
            $table->enum('novo', array('S', 'N'))->default('S');
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
        Schema::drop('contatos');
    }
}
