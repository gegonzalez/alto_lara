<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCitasPromoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_citas_promo', function(Blueprint $table)
		{
			$table->integer('accp_id', true);
			$table->string('accp_name');
			$table->string('accp_lastname');
			$table->string('accp_sexo', 15);
			$table->string('accp_cedula', 15);
			$table->string('accp_fec_nac', 15);
			$table->string('accp_email', 100);
			$table->string('accp_estado', 50);
			$table->string('accp_ciudad', 100);
			$table->string('accp_direccion');
			$table->string('accp_telefono', 50);
			$table->string('accp_tipo', 50);
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
		Schema::drop('ac_citas_promo');
	}

}
