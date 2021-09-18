<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Image;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
