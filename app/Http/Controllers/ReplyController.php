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
        dd($request->toArray());


        $extension = null;
        $fileName = null;
        $path = '';

        if($request->input('tweet') || $request->hasFile('file')) {
            $is_video = $request->input('is_video');

            $tweet = new Reply;
            $tweet->tweet = $request->input('tweet');
            $tweet->visible = $request->input('visible');
            $tweet->user_id = $request->input('user_id');
            $tweet->is_video = $is_video;

            if($is_video === 'n') { // if file is images
                if($request->hasFile('file')) {
                    $fileNamesWithPath = array();
                    $path = '/uploads/posts/pics/';
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
                    // store to the column with serialize() method to make it as array in database and should use unserialize() method when call this column again
                    $tweet->file = serialize($fileNamesWithPath);
                }
            } elseif ($is_video === 'y') { // if file is video
                $file = null;
                $videoFileName = null;
                if($request->hasFile('file')) {
                    $path = '/uploads/posts/videos/';
                    $file = $request->file('file');
                    $request->validate(['file' => 'required|mimes:jpg,jpeg,png,gif,mp4,mov,wmv,avi,avchd,flv,f4v,swf,mkv,webm,html5,mpeg-2,webp']);
                    $extension = $file->getClientOriginalExtension();
                    $videoFileName = time() . '.' . $extension;

                    if($videoFileName) {
                        $tweet->file = $path . $videoFileName;
                        $file->move(public_path() . $path, $videoFileName);
                    }
                }
            }

            $tweet->save();
        }
        return redirect()->back();
    }
}
