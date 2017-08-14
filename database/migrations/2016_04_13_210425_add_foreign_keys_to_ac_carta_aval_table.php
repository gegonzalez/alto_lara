<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcCartaAvalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_carta_aval', function(Blueprint $table)
		{
			$table->foreign('codigo_especialidad', 'ac_carta_aval_ibfk_1')->references('codigo_especialidad')->on('ac_especialidades_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('cedula_afiliado', 'ac_carta_aval_ibfk_2')->references('cedula')->on('ac_afiliados')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_proveedor', 'ac_carta_aval_ibfk_3')->references('codigo_proveedor')->on('ac_proveedores_extranet')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('codigo_contrato', 'ac_carta_aval_ibfk_4')->references('codigo_contrato')->on('ac_contratos')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_carta_aval', function(Blueprint $table)
		{
			$table->dropForeign('ac_carta_aval_ibfk_1');
			$table->dropForeign('ac_carta_aval_ibfk_2');
			$table->dropForeign('ac_carta_aval_ibfk_3');
			$table->dropForeign('ac_carta_aval_ibfk_4');
		});
	}

}
