<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcColectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_colectivos', function(Blueprint $table)
		{
			$table->foreign('codigo_aseguradora', 'ac_colectivos_ibfk_1')->references('codigo_aseguradora')->on('ac_aseguradora')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_colectivos', function(Blueprint $table)
		{
			$table->dropForeign('ac_colectivos_ibfk_1');
			$table->dropForeign('ac_colectivos_ibfk_2');
		});
	}

}
