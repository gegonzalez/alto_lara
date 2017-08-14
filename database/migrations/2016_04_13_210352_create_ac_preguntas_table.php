<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcPreguntasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_preguntas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('esp_id');
			$table->text('pregunta', 65535);
			$table->text('respuesta', 65535);
			$table->string('act', 1);
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
		Schema::drop('ac_preguntas');
	}

}
