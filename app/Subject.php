<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['id', 'name', 'image'];
}
