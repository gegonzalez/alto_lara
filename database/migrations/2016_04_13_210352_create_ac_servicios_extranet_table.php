<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcServiciosExtranetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_servicios_extranet', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_servicio')->unique('ucs_codigo_servicio');
			$table->string('descripcion');
			$table->integer('orden');
			$table->string('act', 1)->default('S');
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
		Schema::drop('ac_servicios_extranet');
	}

}
