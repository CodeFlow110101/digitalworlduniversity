<?php

use App\Models\Program;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount, on};

state(['id', 'url', 'name']);

on([
    'video-completed' => function () {
        VideoProgress::updateOrCreate(
            ['user_id' => Auth::user()->id, 'video_id' => $this->id, 'program_id' => Video::find($this->id)->program_id],
            []
        );
    }
]);

mount(function ($id) {
    $this->id = $id;
    $video =  Video::find($this->id);
    $this->url = $video->video;
    $this->name = $video->name;
});

?>

<div class="bg-[#d6dcde] h-full p-6 rounded-2xl grid grid-cols-1 gap-8">
    <div class="text-center text-[#131e30] text-3xl font-semibold">{{$name}}</div>
    <div x-init="$refs.myVideo.addEventListener('ended', () => { Livewire.dispatch('video-completed'); })" class="w-full">
        <video x-ref="myVideo" class="h-96 w-full rounded-2xl" controls autoplay controlsList="nodownload">
            <source src="{{asset('storage/'.$url)}}" type="video/mp4">
            <source src="{{asset('storage/'.$url)}}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    </div>
</div>