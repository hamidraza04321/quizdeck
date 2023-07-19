<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignPaper extends Model
{
    protected $table = 'assign_papers';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
    	'subject_id', 
    	'group_id', 
    	'paper_id', 
    	'assign_for', 
    	'name', 
        'number_of_questions',
    	'description'
    ];
}
