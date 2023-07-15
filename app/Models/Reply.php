<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'reply', 'file', 'is_video', 'user_id', 'tweet_id'
    ];

    protected $table = 'tweets_replies';

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function tweet() {
        return $this->belongsTo( Tweet::class, 'tweet_id', 'id' );
    }

    public function replies() {
        return $this->hasMany( self::class, 'parent_id', 'id' );
    }



    public function likes() {
        return $this->belongsToMany( User::class, 'replies_likes' )->withTimestamps();
    }

    public function viewed() {
        return $this->belongsToMany( User::class, 'replies_viewed' )->withTimestamps();
    }

    public function bookmarks() {
        return $this->belongsToMany( User::class, 'replies_bookmarks')->withTimestamps();
    }

}
