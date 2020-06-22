<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    public $table="users";
    protected $primaryKey="user_id";
    protected $fillable = ['user_name', 'user_email',"user_password","password"];
}
