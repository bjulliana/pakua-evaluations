<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('evaluations', function(Blueprint $table) {
			$table->foreign('itinerancy_id')->references('id')->on('itinerancies')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('evaluations', function(Blueprint $table) {
			$table->foreign('discipline_id')->references('id')->on('disciplines')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->foreign('evaluation_id')->references('id')->on('evaluations')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->foreign('received_belt_id')->references('id')->on('belts')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->foreign('current_belt_id')->references('id')->on('belts')
						->onDelete('set null')
						->onUpdate('set null');
		});
        Schema::table('students', function(Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructors')
                  ->onDelete('set null')
                  ->onUpdate('set null');
        });
	}

	public function down()
	{
		Schema::table('evaluations', function(Blueprint $table) {
			$table->dropForeign('evaluations_itinerancy_id_foreign');
		});
		Schema::table('evaluations', function(Blueprint $table) {
			$table->dropForeign('evaluations_discipline_id_foreign');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->dropForeign('students_evaluation_id_foreign');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->dropForeign('students_received_belt_id_foreign');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->dropForeign('students_current_belt_id_foreign');
		});
        Schema::table('students', function(Blueprint $table) {
            $table->dropForeign('students_instructor_id_foreign');
        });
	}
}
