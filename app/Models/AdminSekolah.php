<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminSekolah extends Authenticatable
{
    protected $primaryKey = 'id_admin';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
}
