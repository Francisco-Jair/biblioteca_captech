<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gestores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uid');
			$table->string('nome');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
            $table->enum('isAdmin', array('S', 'N'))->default('N');
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
		Schema::drop('gestores');
	}

}
