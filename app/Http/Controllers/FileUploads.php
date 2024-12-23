<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Vimeo\Laravel\Facades\Vimeo;

class FileUploads extends Controller
{
    function storeFile(Request $request)
    {
        $fileName = (string)Str::uuid() . $request->file('file')->getClientOriginalName();
        $filePath =  $request->file('file')->storeAs('files', $fileName, 'public');
        $fileName =  $request->file('file')->getClientOriginalName();

        return ['fileName' => $fileName, 'filePath' => $filePath];
    }

    function storeVideo(Request $request)
    {

        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes

        $videoName = (string)Str::uuid() . $request->file('video')->getClientOriginalName();
        $videoPath =  $request->file('video')->storeAs('videos', $videoName, 'public');
        $response = str_replace("/videos/", '', Vimeo::upload(public_path('storage/' . $videoPath)));
        Storage::disk('public')->delete($videoPath);

        $thumbnailName = (string)Str::uuid() . $request->file('thumbnail')->getClientOriginalName();
        $imagePath = $request->file('thumbnail')->storePublicly('images');
        $imageUrl = Storage::url($imagePath);

        return ['videoName' => $videoName, 'videoPath' => $response, 'thumbnailName' => $thumbnailName, 'thumbnailPath' => $imagePath, 'thumbnailUrl' => $imageUrl];
    }

    function storeThumbnail(Request $request)
    {
        $thumbnailName = (string)Str::uuid() . $request->file('thumbnail')->getClientOriginalName();
        $thumbnailPath = $request->file('thumbnail')->storePublicly('images');
        $thumbnailUrl = Storage::url($thumbnailPath);
        return ['thumbnailName' => $thumbnailName, 'thumbnailPath' => $thumbnailPath, 'thumbnailUrl' => $thumbnailUrl];
    }

    public function storeChatFile(Request $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storePublicly('images');
        $fileUrl = Storage::url($filePath);
        return  ['url' => $fileUrl, 'path' => $filePath, 'name' => $fileName];
    }
}
