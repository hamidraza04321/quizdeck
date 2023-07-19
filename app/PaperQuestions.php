<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaperQuestionOptions;

class PaperQuestions extends Model
{
    protected $table = 'paper_questions';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['paper_id', 'question', 'type', 'explaination'];

    public function getOptions() {
        return $this->hasMany(PaperQuestionOptions::class, 'question_id', 'id');
    }
}
