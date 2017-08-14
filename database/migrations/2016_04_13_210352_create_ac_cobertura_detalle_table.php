<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCoberturaDetalleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_cobertura_detalle', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nombre', 200);
			$table->text('desc', 65535);
			$table->string('short', 50);
			$table->integer('id_cobertura')->index('id_cobertura');
			$table->string('precio', 20)->default('0');
			$table->string('act', 1)->default('S');
			$table->integer('orden');
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
		Schema::drop('ac_cobertura_detalle');
	}

}
