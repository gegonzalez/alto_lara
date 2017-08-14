<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcCartaAvalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_carta_aval', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('codigo_contrato')->index('idx1_codigo_contrato');
			$table->string('cedula_afiliado', 20)->index('idx1_cedula_afiliado');
			$table->date('fecha_solicitud')->nullable();
			$table->date('fecha_emision')->nullable();
			$table->string('motivo_consulta', 300)->nullable();
			$table->integer('codigo_especialidad')->index('idx1_codigo_especialidad');
			$table->string('diagnostico', 300)->nullable();
			$table->string('codigo_examen', 300)->nullable();
			$table->string('email', 300)->nullable();
			$table->decimal('monto', 12, 0)->nullable();
			$table->string('documentos', 300)->nullable();
			$table->integer('estatus')->nullable();
			$table->string('codigo_proveedor', 100)->nullable()->index('idx1_codigo_proveedor');
			$table->string('clave', 30)->nullable();
			$table->integer('creador')->nullable();
			$table->time('hora_guardado')->nullable();
			$table->string('telefono', 75)->nullable();
			$table->text('rechazo', 65535)->nullable();
			$table->integer('cantidad_servicios')->nullable();
			$table->integer('tipo_afiliado')->nullable();
			$table->time('hora_autorizacion')->nullable();
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
		Schema::drop('ac_carta_aval');
	}

}
