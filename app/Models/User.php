<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tbl_user';

    // Define fillable fields
    protected $fillable = [
        'username', 'password', 'gender', 'jobid'
    ];

    // Disable timestamps
    public $timestamps = false;
}
