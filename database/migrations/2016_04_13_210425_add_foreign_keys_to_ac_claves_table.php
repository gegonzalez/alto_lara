<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcClavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_claves', function(Blueprint $table)
		{
			$table->foreign('cedula_afiliado', 'ac_claves_ibfk_1')->references('cedula')->on('ac_afiliados')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_proveedor', 'ac_claves_ibfk_2')->references('codigo_proveedor')->on('ac_proveedores_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_especialidad', 'ac_claves_ibfk_3')->references('codigo_especialidad')->on('ac_especialidades_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_servicio', 'ac_claves_ibfk_4')->references('codigo_servicio')->on('ac_servicios_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_claves', function(Blueprint $table)
		{
			$table->dropForeign('ac_claves_ibfk_1');
			$table->dropForeign('ac_claves_ibfk_2');
			$table->dropForeign('ac_claves_ibfk_3');
			$table->dropForeign('ac_claves_ibfk_4');
		});
	}

}
