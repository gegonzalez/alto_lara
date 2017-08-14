<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('email')->unique();
                        $table->string('password');
			$table->string('department', 50);
			$table->integer('type')->index('type');
			$table->string('user', 20)->unique('avu_user');
			$table->string('act', 1)->default('S');
			$table->integer('proveedor');
                        $table->rememberToken();
                        $table->timestamps();
                        $table->softDeletes();
                        $table->text('salt', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
