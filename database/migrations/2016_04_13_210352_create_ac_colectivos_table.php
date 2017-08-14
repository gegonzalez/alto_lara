<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcColectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_colectivos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_colectivo')->unique('uac_codigo_colectivo');
			$table->string('nombre', 100)->nullable();
			$table->integer('codigo_aseguradora')->index('idxco_codigo_aseguradora');
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
		Schema::drop('ac_colectivos');
	}

}
