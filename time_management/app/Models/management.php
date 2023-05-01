<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class management extends Model
{
    protected $table = 'users';
    public $timestamps = false;
}

class timeManagement extends Model
{
    protected $table = 'userstime';
    public $timestamps = false;
}