<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcTratamientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_tratamiento', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_tratamiento')->nullable();
			$table->text('descripcion', 65535)->nullable();
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
		Schema::drop('ac_tratamiento');
	}

}
