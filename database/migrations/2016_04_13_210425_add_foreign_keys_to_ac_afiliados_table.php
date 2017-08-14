<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcAfiliadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ac_afiliados', function(Blueprint $table)
		{
			$table->foreign('tipo_afiliado', 'ac_afiliados_ibfk_1')->references('id')->on('ac_tipo_afiliado')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ac_afiliados', function(Blueprint $table)
		{
			$table->dropForeign('ac_afiliados_ibfk_1');
		});
	}

}
