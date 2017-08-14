<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCitasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_citas', function(Blueprint $table)
		{
			$table->integer('acc_id', true);
			$table->string('acc_cita', 20);
			$table->string('acc_titular');
			$table->string('acc_cedula_tit', 15)->index('acc_cedula_tit');
			$table->string('acc_beneficiario');
			$table->string('acc_cedula_ben', 30);
			$table->string('acc_email', 100);
			$table->string('acc_estado', 50);
			$table->string('acc_ciudad', 100);
			$table->string('acc_direccion');
			$table->string('acc_telefono', 50);
			$table->string('acc_movil');
			$table->dateTime('acc_fecha_sol');
			$table->integer('acc_especialidad');
			$table->string('acc_horario', 11);
			$table->integer('acc_tipo_cita');
			$table->string('acc_status', 1)->default('N');
			$table->string('acc_aseguradora');
			$table->string('acc_trabajo');
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
		Schema::drop('ac_citas');
	}

}
