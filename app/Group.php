<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['name'];
}
