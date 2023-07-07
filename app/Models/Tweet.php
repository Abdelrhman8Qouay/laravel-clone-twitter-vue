<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet', 'file', 'is_video', 'visible', 'user_id'
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function likes() {
        return $this->belongsToMany( User::class, 'tweets_likes' )->withTimestamps();
    }

    public function retweets() {
        return $this->belongsToMany( User::class, 'tweets_retweets')->withTimestamps();
    }

    public function bookmarks() {
        return $this->belongsToMany( User::class, 'tweets_bookmarks')->withTimestamps();
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }
}
