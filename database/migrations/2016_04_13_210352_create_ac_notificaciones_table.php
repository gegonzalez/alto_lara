<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcNotificacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ac_notificaciones', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('notificacion', 65535)->nullable();
			$table->text('enviado_a', 65535)->nullable();
			$table->string('enviado_por', 50)->nullable();
			$table->text('respuesta', 65535)->nullable();
			$table->integer('id_notificacion')->nullable();
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
		Schema::drop('ac_notificaciones');
	}

}
