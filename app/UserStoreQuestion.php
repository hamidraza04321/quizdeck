<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\{
    PaperQuestions,
    UserStoreOption
};

class UserStoreQuestion extends Model
{
    protected $table = 'user_store_questions';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['assign_paper_student_id', 'paper_id', 'question_id', 'un_answered'];

    public function question()
    {
    	return $this->hasMany(PaperQuestions::class, 'id', 'question_id');
    }

    public function checkedOptions()
    {
        return $this->hasMany(UserStoreOption::class, 'store_question_id', 'id');
    }
}
