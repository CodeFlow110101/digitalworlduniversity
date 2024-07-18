<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploads extends Controller
{
    function store(Request $request)
    {

        return 'hello';
    }

    function storeVideo(Request $request)
    {

        $videoName = (string)Str::uuid() . $request->file('video')->getClientOriginalName();
        $videoPath =  $request->file('video')->storeAs('videos', $videoName, 'public');

        $thumbnailName = (string)Str::uuid() . $request->file('thumbnail')->getClientOriginalName();
        $thumbnailPath =  $request->file('thumbnail')->storeAs('images', $thumbnailName, 'public');

        return ['videoName' => $videoName, 'videoPath' => $videoPath, 'thumbnailName' => $thumbnailName, 'thumbnailPath' => $thumbnailPath];
    }

    function storeThumbnail(Request $request)
    {
        $thumbnailName = (string)Str::uuid() . $request->file('thumbnail')->getClientOriginalName();
        $thumbnailPath =  $request->file('thumbnail')->storeAs('images', $thumbnailName, 'public');

        return ['thumbnailName' => $thumbnailName, 'thumbnailPath' => $thumbnailPath];
    }
}
