<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TweetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tweets')->insert([
            'tweet'=> 'This My Firsst post 😀 haaaai THia aJ Kj K Jk JK k KLGNklgN  GKLN GKLN GKLN gklnKLGN gkl...',
            'file'=> '/uploads/posts/pics/land_world.png',
            'is_video'=> false,
            'comments'=> 35,
            'retweets'=> 15,
            'likes'=> 95154,
            'analytics'=> 1546879,
            'image'=> 'https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png',
            'name'=> 'Qouaynt Que',
            'handle'=> 'AbdelrhmanQouay',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
