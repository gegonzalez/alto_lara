<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcProveedoresExtranetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_proveedores_extranet', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('codigo_proveedor', 100)->unique('idxp1_codigo_proveedor');
			$table->string('cedula', 100)->nullable();
			$table->string('nombre', 100)->nullable();
			$table->date('fecha_nacimiento')->nullable();
			$table->integer('codigo_especialidad')->nullable();
			$table->text('direccion')->nullable();
			$table->string('telefono_casa', 20)->nullable();
			$table->string('telefono_movil', 20)->nullable();
			$table->text('urbanizacion')->nullable();
			$table->integer('codigo_estado')->nullable();
			$table->string('ciudad', 100)->nullable();
			$table->string('email', 100)->nullable();
			$table->integer('colegiatura')->nullable();
			$table->string('msas', 100)->nullable();
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
		Schema::drop('ac_proveedores_extranet');
	}

}
