<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_contratos', function(Blueprint $table)
		{
			$table->foreign('cedula_afiliado', 'ac_contratos_ibfk_1')->references('cedula')->on('ac_afiliados')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_contratos', function(Blueprint $table)
		{
			$table->dropForeign('ac_contratos_ibfk_1');
		});
	}

}
