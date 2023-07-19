<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assign_paper_student_id')
                    ->references('id')
                    ->on('assign_paper_students')
                    ->onDelete('cascade');
            $table->integer('paper_id');
            $table->integer('question_id');
            $table->integer('un_answered');
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
        Schema::dropIfExists('user_store_questions');
    }
}
