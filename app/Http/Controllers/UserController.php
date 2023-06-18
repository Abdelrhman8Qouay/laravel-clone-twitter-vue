<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Inertia\Inertia;

use App\Models\Tweet;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Susers', [
            'check_auth' => auth()->check(),
            'user_auth' => auth()->user(),
            'all_users' => User::all(),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($name)
    {
        $userUsed = User::where('handle_name', '=',$name)->first();

        return Inertia::render('Profiling', [
            'user_own' => User::where('handle_name', '=',$name)->first(),
            'tweets_own' => Tweet::orderBy('id', 'desc')->with('user')->get()->where('user_id', '=',$userUsed->id),
            'check_auth' => auth()->check(),
            'user_auth' => auth()->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // get user from user auth who can edit the profile of him only and this user only what i want to access on it
        $user = User::find(auth()->user()->id);


        $pathHead = '/uploads/users/heads/';
        $pathAvatar = '/uploads/users/avatars/';
        $imgHead = null;
        $imgAvatar = null;


        if($request->input('head_image') === $user->head_image) {
            $imgHead = $user->head_image;
        }else {
            $base64Img = $request->input('head_image');
            // decode the base64 file
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Img));

            // save it to temporary dir first.
            $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);

            // this just to help us get file info.
            $tmpFile = new File($tmpFilePath);

            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true // Mark it as test, since the file isn't from real HTTP POST.
            );
            $ext = $file->clientExtension();

            $fileName = time() . '_H.' . $ext;

            if (!is_null($user->head_image) && file_exists(public_path() . $user->head_image) && $user->head_image !== ($pathHead . 'empty_head.jpg')) {
                unlink(public_path() . $user->head_image);
            }

            if($file) {
                $imgHead = $pathHead . $fileName;
                $file->move(public_path() . $pathHead, $fileName);
            }
        }

        if($request->input('avatar') === $user->avatar) {
            $imgAvatar = $user->avatar;
        }else {
            $base64Img = $request->input('avatar');
            // decode the base64 file
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Img));

            // save it to temporary dir first.
            $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);

            // this just to help us get file info.
            $tmpFile = new File($tmpFilePath);

            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true // Mark it as test, since the file isn't from real HTTP POST.
            );
            $ext = $file->clientExtension();

            $fileName = time() . '_A.' . $ext;

            if (!is_null($user->avatar) && file_exists(public_path() . $user->avatar) && $user->avatar !== ($pathAvatar . 'empty_user.png')) {
                unlink(public_path() . $user->avatar);
            }

            if($file) {
                $imgAvatar = $pathAvatar . $fileName;
                $file->move(public_path() . $pathAvatar, $fileName);
            }
        }

        $request->validate(['name' => 'required']);

        $user->head_image = $imgHead;
        $user->avatar = $imgAvatar;
        $user->name = $request->input('name');
        $user->bio = $request->input('bio');
        $user->location = $request->input('location');
        $user->website_url = $request->input('website_url');

        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}
