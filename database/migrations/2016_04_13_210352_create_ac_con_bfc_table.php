<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcConBfcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_con_bfc', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 50);
			$table->string('last', 50);
			$table->string('tdc', 30);
			$table->string('fec_exp', 10);
			$table->string('telefono', 30);
			$table->string('cedula', 20);
			$table->string('email', 50);
			$table->dateTime('cdate');
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
		Schema::drop('ac_con_bfc');
	}

}
