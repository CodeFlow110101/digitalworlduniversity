<?php

use App\Models\Video;

use function Livewire\Volt\{state, mount};

state(['id', 'url', 'name']);

mount(function ($id) {
    $this->id = $id;
    $video =  Video::find($this->id);
    $this->url = $video->video;
    $this->name = $video->name;
});

?>

<div class="bg-[#d6dcde] h-full p-6 rounded-2xl grid grid-cols-1 gap-8">
    <div class="text-center text-[#131e30] text-3xl font-semibold">{{$name}}</div>
    <div class="w-full">
        <video class="h-96 w-full rounded-2xl" controls controlsList="nodownload">
            <source src="{{asset('storage/'.$url)}}" type="video/mp4">
            <source src="{{asset('storage/'.$url)}}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    </div>
</div>