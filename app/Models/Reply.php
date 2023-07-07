<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function tweet() {
        return $this->belongsTo( Tweet::class, 'tweet_id', 'id' );
    }

    public function replies() {
        return $this->hasMany( self::class, 'parent_id', 'id' );
    }
}
