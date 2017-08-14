<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCoberturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_cobertura', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nombre');
			$table->text('desc', 65535);
			$table->string('slogan', 150);
			$table->string('img', 50);
			$table->text('banner', 65535);
			$table->text('icon', 65535);
			$table->string('color', 8);
			$table->integer('orden');
			$table->string('act', 1)->default('S');
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
		Schema::drop('ac_cobertura');
	}

}
