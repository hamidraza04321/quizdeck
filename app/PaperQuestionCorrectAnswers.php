<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaperQuestionCorrectAnswers extends Model
{
    protected $table = 'paper_question_correct_answers';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['paper_id', 'question_id', 'option_id'];
}
