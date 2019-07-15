<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->year('year');
            $table->tinyInteger('averageScore')->default(0);
            $table->boolean('confirmingStudent')->default(false);
            $table->boolean('confirmingClass')->default(false);
            $table->boolean('confirmingFaculty')->default(false);
            $table->boolean('confirmingSchool')->default(false);
            $table->string('student_id', 10);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_boards');
    }
}
