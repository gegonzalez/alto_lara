<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_contratos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_contrato')->unique('idx2_codigo_contrato');
			$table->string('cedula_afiliado', 20)->index('idx2_cedula_afiliado');
			$table->date('fecha_inicio')->nullable();
			$table->date('fecha_fin')->nullable();
			$table->integer('codigo_colectivo')->nullable()->index('idx2_codigo_colectivo');
			$table->integer('codigo_plan')->nullable();
			$table->index(['codigo_contrato','codigo_colectivo'], 'idx_2');
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
		Schema::drop('ac_contratos');
	}

}
