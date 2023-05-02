<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('evaluation_id')->unsigned();
			$table->string('name', 255);
			$table->string('receipt_number', 255)->nullable();
			$table->integer('instructor_id')->unsigned()->nullable();
            $table->integer('current_belt_id')->unsigned()->nullable();
            $table->integer('has_stripes')->nullable();
            $table->integer('months_practice')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->string('evaluating_for', 255)->nullable();
			$table->tinyInteger('activity_1')->nullable();
			$table->tinyInteger('activity_2')->nullable();
			$table->tinyInteger('activity_3')->nullable();
			$table->tinyInteger('activity_4')->nullable();
			$table->tinyInteger('activity_5')->nullable();
			$table->tinyInteger('activity_6')->nullable();
            $table->integer('received_belt_id')->unsigned()->nullable();
            $table->tinyInteger('received_stripes')->nullable();
			$table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('students');
	}
};
