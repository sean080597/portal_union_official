<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreboardSchoolsactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoreboard_schoolsactivity', function (Blueprint $table) {
            $table->increments('id');
            $table->float('average_score')->default(0);
            $table->float('student_score')->default(0);
            $table->float('class_score')->default(0);
            $table->float('faculty_score')->default(0);
            $table->float('school_score')->default(0);
            $table->integer('score_board_id')->unsigned();
            $table->integer('schools_activity_id')->unsigned();
            $table->foreign('score_board_id')->references('id')->on('score_boards')->onDelete('cascade');
            $table->foreign('schools_activity_id')->references('id')->on('schools_activities')->onDelete('cascade');
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
        Schema::dropIfExists('scoreboard_schoolsactivity');
    }
}
