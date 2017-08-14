<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcServiciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_servicios', function(Blueprint $table)
		{
			$table->integer('acs_id', true);
			$table->string('acs_nombre');
			$table->text('acs_desc', 65535);
			$table->string('acs_slogan', 150);
			$table->string('acs_img', 50);
			$table->text('acs_banner', 65535);
			$table->text('acs_icon', 65535);
			$table->string('acs_color', 8);
			$table->integer('acs_orden');
			$table->string('acs_act', 1)->default('S');
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
		Schema::drop('ac_servicios');
	}

}
