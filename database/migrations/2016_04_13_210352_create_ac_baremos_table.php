<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcBaremosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_baremos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_baremos');
			$table->integer('codigo_aseguradora');
			$table->integer('codigo_servicio');
			$table->text('observaciones', 65535);
			$table->float('monto', 10, 0);
			$table->text('usuario_creador', 65535);
			$table->text('usuario_modifico', 65535);
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
		Schema::drop('ac_baremos');
	}

}
