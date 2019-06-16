<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreboardSelfactivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoreboard_selfactivity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity_content');
            $table->float('average_score')->default(0);
            $table->boolean('confirmingStudent')->default(false);
            $table->boolean('confirmingClass')->default(false);
            $table->boolean('confirmingFaculty')->default(false);
            $table->boolean('confirmingSchool')->default(false);
            $table->integer('score_board_id')->unsigned();
            $table->integer('self_activity_id')->unsigned();
            $table->foreign('score_board_id')->references('id')->on('score_boards')->onDelete('cascade');
            $table->foreign('self_activity_id')->references('id')->on('self_activities')->onDelete('cascade');
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
        Schema::dropIfExists('scoreboard_selfactivity');
    }
}
