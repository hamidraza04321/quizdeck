<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'papers';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['subject_id', 'name', 'number_of_questions', 'description'];

    public function subject(){
        return $this->belongsTo('App\Subject', 'subject_id');
    }
}
