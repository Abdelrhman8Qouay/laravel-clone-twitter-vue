<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reply;
use App\Models\Tweet;
use App\Models\User;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $extension = null;
        $fileName = null;
        $path = '';

        if($request->input('tweet') || $request->hasFile('file')) {
            $is_video = $request->input('is_video');

            $reply = new Reply;

            $reply->reply = $request->input('tweet');
            $reply->is_video = $is_video;
            $reply->user_id = $request->input('user_id');
            $reply->tweet_id = $request->input('tweet_id');

            if($is_video === 'n') { // if file is images
                if($request->hasFile('file')) {
                    $fileNamesWithPath = array();
                    $path = '/uploads/replies/pics/';
                    $files = $request->files->get('file');
                    // forEach file of them handle alone as an image
                    foreach ($files as $key => $valueFile) {
                        $extension = $valueFile->getClientOriginalExtension();
                        $fileName = time() . '_i' . $key . '.' . $extension;
                        // to make it as one array and send it to the database
                        array_push($fileNamesWithPath, $path . $fileName);

                        if($fileName) {
                            $valueFile->move(public_path() . $path, $fileName);
                        }
                    }
                    // store as string with split them with (|) to get them again simply
                    $reply->file = implode("|", $fileNamesWithPath);
                }
            } elseif ($is_video === 'y') { // if file is video
                $file = null;
                $videoFileName = null;
                if($request->hasFile('file')) {
                    $path = '/uploads/replies/videos/';
                    $file = $request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $videoFileName = time() . '.' . $extension;

                    if($videoFileName) {
                        $reply->file = $path . $videoFileName;
                        $file->move(public_path() . $path, $videoFileName);
                    }
                }
            }

            $reply->save();
        }
        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user likes.
     */
    public function toggleLikes($reply) {
        Reply::where('id', '=',$reply)->first()->likes()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user bookmarks.
     */
    public function toggleBookmarks($reply) {
        Reply::where('id', '=',$reply)->first()->bookmarks()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user viewed.
     */
    public function toggleViewed($reply) {
        Reply::where('id', '=',$reply)->first()->viewed()->toggle(auth()->id());

        return redirect()->back();
    }
}
