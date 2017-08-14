<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcProcedimientosMedicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_procedimientos_medicos', function(Blueprint $table)
		{
			$table->foreign('codigo_especialidad', 'ac_procedimientos_medicos_ibfk_1')->references('codigo_especialidad')->on('ac_especialidades_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_servicio', 'ac_procedimientos_medicos_ibfk_2')->references('codigo_servicio')->on('ac_servicios_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_procedimientos_medicos', function(Blueprint $table)
		{
			$table->dropForeign('ac_procedimientos_medicos_ibfk_1');
			$table->dropForeign('ac_procedimientos_medicos_ibfk_2');
		});
	}

}
