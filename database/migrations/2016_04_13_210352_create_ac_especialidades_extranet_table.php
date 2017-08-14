<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcEspecialidadesExtranetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_especialidades_extranet', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_especialidad')->unique('uae_codigo_especialidad');
			$table->string('rama', 100);
			$table->string('descripcion');
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
		Schema::drop('ac_especialidades_extranet');
	}

}
