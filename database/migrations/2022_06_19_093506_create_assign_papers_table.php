<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_papers', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id');
            $table->integer('group_id');
            $table->foreignId('paper_id')->references('id')->on('papers')->onDelete('cascade');
            $table->string('assign_for');
            $table->string('name');
            $table->string('number_of_questions');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('assign_papers');
    }
}
