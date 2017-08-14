<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcFacturasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_facturas', function(Blueprint $table)
		{
			$table->foreign('clave', 'ac_facturas_ibfk_1')->references('clave')->on('ac_claves')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_facturas', function(Blueprint $table)
		{
			$table->dropForeign('ac_facturas_ibfk_1');
		});
	}

}
