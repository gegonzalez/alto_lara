<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcAseguradoraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_aseguradora', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_aseguradora')->unique('codigo_aseguradora');
			$table->string('nombre', 100);
			$table->string('rif', 10);
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
		Schema::drop('ac_aseguradora');
	}

}
