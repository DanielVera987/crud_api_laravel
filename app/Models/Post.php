<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'Post';

    public function user()
    {
        $this->belongsTo('users');
    }
}
