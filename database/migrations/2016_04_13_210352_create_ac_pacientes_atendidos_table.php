<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcPacientesAtendidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_pacientes_atendidos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_titular');
			$table->integer('id_paciente');
			$table->string('nombre');
			$table->string('telefono', 50);
			$table->integer('tipo');
			$table->string('procedimiento');
			$table->string('clave');
			$table->integer('id_profesional');
			$table->date('fecha');
			$table->integer('codigo_aseguradora')->nullable();
			$table->integer('codigo_colectivo')->nullable();
			$table->decimal('monto', 10)->nullable();
			$table->text('motivo')->nullable();
			$table->integer('servicio')->nullable();
			$table->string('patologia', 100)->nullable();
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
		Schema::drop('ac_pacientes_atendidos');
	}

}
