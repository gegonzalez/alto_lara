<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcDetalleServiciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_detalle_servicios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_servicio')->nullable()->index('codigo_servicio');
			$table->string('descripcion', 100)->nullable();
			$table->string('orden', 100)->nullable();
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
		Schema::drop('ac_detalle_servicios');
	}

}
