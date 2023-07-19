<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaperQuestionCorrectAnswers;

class PaperQuestionOptions extends Model
{
    protected $table = 'paper_question_options';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['paper_id', 'question_id', 'option'];

    public function correctAnswers()
    {
        return $this->hasMany(PaperQuestionCorrectAnswers::class, 'option_id', 'id');
    }
}
