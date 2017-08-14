<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubmodulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('submodules', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('description', 65535);
			$table->integer('modules_id');
			$table->string('url', 100);
			$table->integer('order');
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
		Schema::drop('submodules');
	}

}
