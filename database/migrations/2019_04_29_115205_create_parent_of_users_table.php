<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentOfUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_of_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->date('birthday')->nullable();
            $table->char('phone', 10)->nullable();
            $table->string('job')->nullable();
            $table->boolean('sex')->nullable();//dad or mom
            $table->char('student_id', 10);
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
        Schema::dropIfExists('parent_of_users');
    }
}
