<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCitasOdontologicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_citas_odontologicas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_paciente')->nullable();
			$table->text('clave', 65535)->nullable();
			$table->date('fecha1')->nullable();
			$table->date('fecha2')->nullable();
			$table->date('fecha3')->nullable();
			$table->integer('estatus')->nullable();
			$table->date('fecha_creacion')->nullable();
			$table->date('fecha_modifico')->nullable();
			$table->integer('usuario_creador')->nullable();
			$table->integer('usuario_modifico')->nullable();
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
		Schema::drop('ac_citas_odontologicas');
	}

}
