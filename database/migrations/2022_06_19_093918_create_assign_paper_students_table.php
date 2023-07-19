<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignPaperStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_paper_students', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('subject_id');
            $table->foreignId('assign_paper_id')->references('id')->on('assign_papers')->onDelete('cascade');
            $table->integer('paper_id');
            $table->string('status');
            $table->integer('time');
            $table->integer('correct')->nullable();
            $table->integer('incorrect')->nullable();
            $table->integer('un_answered')->nullable();
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
        Schema::dropIfExists('assign_paper_students');
    }
}
