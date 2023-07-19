<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaperQuestionOptions;

class UserStoreOption extends Model
{
    protected $table = 'user_store_options';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['store_question_id', 'assign_paper_student_id', 'question_id', 'option_id', 'is_true'];
}
