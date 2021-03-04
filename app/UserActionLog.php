<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActionLog extends Model
{
    protected $fillable = ['book_id', 'user_id', 'action'];
}
