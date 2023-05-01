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
			$table->string('receipt_number', 255);
			$table->string('instructor', 255);
            $table->integer('current_belt_id')->unsigned()->nullable();
            $table->integer('has_stripes')->nullable();
            $table->integer('months_practice')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->string('evaluating_for', 255)->nullable();
			$table->double('activity_1', 2,2)->nullable();
			$table->double('activity_2', 2,2)->nullable();
			$table->double('activity_3', 2,2)->nullable();
			$table->double('activity_4', 2,2)->nullable();
			$table->double('activity_5', 2,2)->nullable();
			$table->double('activity_6', 2,2)->nullable();
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
