<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcFacturasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_facturas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('clave', 10)->index('clave');
			$table->integer('numero_factura')->index('idxf1_numero_factura');
			$table->integer('numero_control')->nullable();
			$table->date('fecha_factura')->nullable();
			$table->decimal('monto', 10);
			$table->text('observaciones')->nullable();
			$table->date('fecha_creacion')->nullable();
			$table->integer('usuario_creador')->nullable();
			$table->integer('status')->nullable();
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
		Schema::drop('ac_facturas');
	}

}
