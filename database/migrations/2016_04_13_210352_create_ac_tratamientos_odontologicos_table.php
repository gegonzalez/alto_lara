<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcTratamientosOdontologicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_tratamientos_odontologicos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('clave', 65535)->nullable();
			$table->integer('tratamiento_realizado')->nullable();
			$table->date('fecha_tratamiento')->nullable();
			$table->text('dientes', 65535)->nullable();
			$table->integer('estatus')->nullable();
			$table->date('fecha_creacion')->nullable();
			$table->date('fecha_modifico')->nullable();
			$table->integer('usuario_creador')->nullable();
			$table->integer('usuario_modifico')->nullable();
			$table->text('rechazo', 65535)->nullable();
			$table->text('doc1', 65535)->nullable();
			$table->text('doc2', 65535)->nullable();
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
		Schema::drop('ac_tratamientos_odontologicos');
	}

}
