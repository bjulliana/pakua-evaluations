<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up()
	{
		Schema::create('evaluations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('itinerancy_id')->unsigned();
			$table->integer('discipline_id')->unsigned();
			$table->date('date');
			$table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('evaluations');
	}
};
