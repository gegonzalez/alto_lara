<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerLateralTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_lateral', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('img', 65535);
			$table->text('url', 65535);
			$table->integer('orden');
			$table->integer('tipo');
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
		Schema::drop('banner_lateral');
	}

}
