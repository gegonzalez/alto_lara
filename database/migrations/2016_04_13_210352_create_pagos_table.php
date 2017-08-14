<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->integer('mes');
			$table->integer('ano');
			$table->string('monto');
			$table->date('fecha_corte');
			$table->string('numero_factura')->index('idxcp_numero_factura');
			$table->date('fecha_factura');
			$table->date('fecha_recibo_factura');
			$table->date('fecha_pago');
			$table->integer('numero_deposito');
			$table->integer('status');
			$table->dateTime('fecha_creacion');
			$table->float('retencion', 10)->nullable();
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
		Schema::drop('pagos');
	}

}
