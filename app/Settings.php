<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['app_name', 'logo', 'user_registration'];
}
