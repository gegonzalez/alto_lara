<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcProcedimientosMedicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_procedimientos_medicos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_examen')->index('idxpm1_codigo_examen');
			$table->integer('codigo_especialidad')->index('idxpm2_codigo_especialidad');
			$table->integer('codigo_servicio')->index('idxpm3_codigo_servicio');
			$table->string('tipo_examen', 100)->nullable();
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
		Schema::drop('ac_procedimientos_medicos');
	}

}
