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
        $fileName = (string)Str::uuid() . $request->file('file')->getClientOriginalName();
        $filePath =  $request->file('file')->storeAs('videos', $fileName, 'public');

        return ['file_name' => $fileName, 'file_path' => $filePath];
    }
}
