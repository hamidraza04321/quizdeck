<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_options', function (Blueprint $table) {
            $table->id();
            $table->integer('store_question_id');
            $table->foreignId('assign_paper_student_id')
                    ->references('id')
                    ->on('assign_paper_students')
                    ->onDelete('cascade');
            $table->integer('question_id');
            $table->integer('option_id');
            $table->integer('is_true');
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
        Schema::dropIfExists('user_store_options');
    }
}
