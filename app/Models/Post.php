<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'Post';

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
