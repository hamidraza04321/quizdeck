<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\{
	UserStoreQuestion,
	UserStoreOptions
};

class AssignPaperStudents extends Model
{
    protected $table = 'assign_paper_students';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'user_id',
        'subject_id',
        'assign_paper_id',
        'paper_id',
        'status',
        'time',
        'correct',
        'incorrect',
        'un_answered',
    ];

    public function paper(){
        return $this->belongsTo('App\Paper', 'paper_id');
    }

    public function attemptQuestions()
    {
    	return $this->hasMany(UserStoreQuestion::class, 'assign_paper_student_id')->orderBy('question_id', 'ASC');
    }

    public function assignPaper()
    {
        return $this->belongsTo('App\AssignPaper', 'assign_paper_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
