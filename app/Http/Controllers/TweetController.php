<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'tweets' => Tweet::orderBy('id', 'desc')->with('user')->get(),
            // 'users_tweeted' => User::where('name', '=',$name)->get(),
            'check_auth' => auth()->check(),
            'user_auth' => auth()->user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';
        $imageTypes = array("png", "gif", "jpg", "jpeg", "webm", "webp");

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate(['file' => 'required|mimes:jpg,jpeg,png,gif,mp4,mov,wmv,avi,avchd,flv,f4v,swf,mkv,webm,html5,mpeg-2,webp']);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            in_array($extension, $imageTypes) ? $path = '/uploads/posts/pics/' : $path = '/uploads/posts/videos/';
        }

        $tweet = new Tweet;

        $tweet->tweet = $request->input('tweet');
        $tweet->visible = $request->input('visible');
        $tweet->user_id = $request->input('user_id');
        if($fileName) {
            $tweet->file = $path . $fileName;
            $tweet->is_video = in_array($extension, $imageTypes) ? false : true;
            $file->move(public_path() . $path, $fileName);
        }
        $tweet->comments = 0;
        $tweet->retweets = 0;
        $tweet->likes = 0;
        $tweet->analytics = 0;

        $tweet->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);

        if (!is_null($tweet->file) && file_exists(public_path() . $tweet->file)) {
            unlink(public_path() . $tweet->file);
        }

        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}
