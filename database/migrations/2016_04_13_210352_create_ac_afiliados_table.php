<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcAfiliadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_afiliados', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cedula', 20)->unique('ua_cedula');
			$table->string('nombre', 500);
			$table->string('apellido', 500);
			$table->date('fecha_nacimiento');
			$table->string('email', 500);
			$table->string('sexo', 10);
			$table->string('val_user', 10)->default('N');
			$table->integer('tipo_afiliado')->index('idxa_tipo_afiliado');
			$table->string('telefono', 50)->nullable();
			$table->string('cedula_titular', 50)->nullable();
			$table->index(['apellido','nombre','cedula','tipo_afiliado'], 'idx_1');
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
		Schema::drop('ac_afiliados');
	}

}
