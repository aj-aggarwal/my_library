<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Crypt;

class Book extends Model
{
    protected $fillable = ['title', 'isbn', 'published_at', 'status'];

    protected $appends = ['encrypted_id'];

    public function getEncryptedIdAttribute()
    {
    	return Crypt::encrypt($this->id);
    }
}
