<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

use App\Models\Reply;
use App\Models\Tweet;
use App\Models\User;
// to get helper to make the slug
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;

use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPSTORM_META\type;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $tweets = Tweet::latest('created_at')->latest('id')->with('user.following', 'user.followers')->withCount( ['likes as liked' => function($q) {
            $q->where('user_id', auth()->id());
        },'retweets as retweeted' => function($q) {
            $q->where('user_id', auth()->id());
        },'bookmarks as marked' => function($q) {
            $q->where('user_id', auth()->id());
        },'viewed as vieweded' => function($q) {
            $q->where('user_id', auth()->id());
        }, 'likes', 'retweets', 'bookmarks', 'viewed', 'replies'])->withCasts(['liked' => 'boolean', 'retweets' => 'boolean', 'bookmarks' => 'boolean', 'vieweded' => 'boolean'])->paginate(PAGINATION_COUNT);

        if($request->wantsJson()) {
            return $tweets;
        }

        return Inertia::render('Welcome', [
            'tweets' => $tweets,
            'check_auth' => auth()->check(),
            'user_auth' => auth()->user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $extension = null;
        $fileName = null;
        $path = '';

        if($request->input('tweet') || $request->hasFile('file')) {
            $is_video = $request->input('is_video');

            $tweet = new Tweet;
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
                    // store as string with split them with (|) to get them again simply
                    $tweet->file = implode("|", $fileNamesWithPath);
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
        return redirect()->back()->with('success', 'Successful Tweet Posted');
    }

    /**
     * Display the specified tweet.
     */
    public function show(Request $request ,$name, $tweet_id) {
        // get all tweets
        $tweeta = Tweet::with('user','user.following', 'user.followers')->withCount( ['likes as liked' => function($q) {
            $q->where('user_id', auth()->id());
        },'retweets as retweeted' => function($q) {
            $q->where('user_id', auth()->id());
        },'bookmarks as marked' => function($q) {
            $q->where('user_id', auth()->id());
        }, 'likes', 'retweets', 'bookmarks', 'viewed'])->withCasts(['liked' => 'boolean', 'retweets' => 'boolean', 'bookmarks' => 'boolean'])->get()->find($tweet_id);

        // dd($tweeta);
        // get all replies of this tweet
        $replies = Reply::latest('created_at')->latest('id')->where('tweet_id', $tweet_id)->with('user','user.following', 'user.followers')->withCount( ['likes as liked' => function($q) {
            $q->where('user_id', auth()->id());
        },'bookmarks as marked' => function($q) {
            $q->where('user_id', auth()->id());
        },'viewed as vieweded' => function($q) {
            $q->where('user_id', auth()->id());
        }, 'likes', 'bookmarks', 'viewed', 'replies'])->withCasts(['liked' => 'boolean', 'bookmarks' => 'boolean', 'vieweded' => 'boolean'])->paginate(PAGINATION_COUNT);
        if($request->wantsJson()) {
            return $replies;
        }

        return Inertia::render('Tweets/Show', [
            'tweet' => $tweeta,
            'replies' => $replies,
            'user_following_count' => $tweeta->user->followers->count(),
            'user_followers_count' => $tweeta->user->following->count(),
        ]);

        return redirect()->refresh();
    }

    /**
     * Attach & Detach (toggle) user likes.
     */
    public function toggleLikes($tweet) {
        Tweet::where('id', '=',$tweet)->first()->likes()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user retweets.
     */
    public function toggleRetweets($tweet) {
        Tweet::where('id', '=',$tweet)->first()->retweets()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user bookmarks.
     */
    public function toggleBookmarks($tweet) {
        Tweet::where('id', '=',$tweet)->first()->bookmarks()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user viewed.
     */
    public function toggleViewed($tweet) {
        Tweet::where('id', '=',$tweet)->first()->viewed()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Attach & Detach (toggle) user pinned.
     */
    public function togglePin($tweet) {
        Tweet::where('id', '=',$tweet)->first()->pin()->toggle(auth()->id());

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $tweet = Tweet::find($id);

        if (!is_null($tweet->file) && file_exists(public_path() . $tweet->file)) {
            unlink(public_path() . $tweet->file);
        }

        $tweet->delete();

        return redirect()->back();
    }
}
