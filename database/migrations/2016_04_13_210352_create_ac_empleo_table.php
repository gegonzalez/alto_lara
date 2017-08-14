<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcEmpleoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_empleo', function(Blueprint $table)
		{
			$table->integer('ace_id', true);
			$table->string('ace_nombre', 200);
			$table->string('ace_apellido', 200);
			$table->string('ace_email', 200);
			$table->integer('ace_estado');
			$table->string('ace_ciudad', 200);
			$table->string('ace_telefono', 200);
			$table->string('ace_especialidad', 200);
			$table->text('ace_cv', 65535);
			$table->dateTime('ace_fecha_sol');
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
		Schema::drop('ac_empleo');
	}

}
