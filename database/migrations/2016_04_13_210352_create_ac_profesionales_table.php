<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcProfesionalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_profesionales', function(Blueprint $table)
		{
			$table->integer('acp_id', true);
			$table->integer('acp_es_id');
			$table->string('acp_ciudad', 100);
			$table->text('acp_direccion', 65535);
			$table->string('acp_profesional');
			$table->string('acp_telefono', 100);
			$table->integer('acp_acr_id');
			$table->string('acp_ace_id');
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
		Schema::drop('ac_profesionales');
	}

}
