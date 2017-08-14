<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_soporte', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_user');
			$table->text('solicitud');
			$table->text('respuesta');
			$table->date('fecha_creacion');
			$table->date('fecha_respuesta');
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
		Schema::drop('ac_soporte');
	}

}
