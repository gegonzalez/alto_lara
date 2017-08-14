<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcPlanesExtranetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_planes_extranet', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_plan')->unique('upe1_codigo_plan');
			$table->string('nombre', 200);
			$table->string('cobertura', 100)->nullable();
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
		Schema::drop('ac_planes_extranet');
	}

}
