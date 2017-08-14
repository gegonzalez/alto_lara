<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcClavesDetalleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_claves_detalle', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_clave')->nullable()->index('id_clave');
			$table->integer('codigo_especialidad')->nullable();
			$table->integer('codigo_servicio')->nullable();
			$table->integer('codigo_examen')->nullable();
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
		Schema::drop('ac_claves_detalle');
	}

}
