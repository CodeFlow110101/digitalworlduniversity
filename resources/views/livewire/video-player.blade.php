<?php

use App\Models\Program;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount, on};

state(['id', 'url', 'name', 'program_id', 'allowedVideoIds', 'nextVideoId']);

on([
    'video-completed' => function () {
        VideoProgress::updateOrCreate(
            ['user_id' => Auth::user()->id, 'video_id' => $this->id, 'program_id' => $this->program_id],
            []
        );

        $user_video_progress = VideoProgress::select('video_id')->where('user_id', Auth::user()->id)->where('program_id', $this->program_id)->get()->toArray();
        $allVideoIds = Video::select('id')->where('program_id', $this->program_id)->get()->toArray();

        $allowedVideoIds = [];

        $i = 0;

        for ($i = 0; $i <= count($user_video_progress) - 1; $i++) {
            $allowedVideoIds[] = $allVideoIds[$i];
        }

        if (array_key_exists($i, $allVideoIds)) {
            $allowedVideoIds[] = $allVideoIds[$i];
        }

        $this->allowedVideoIds = [];

        foreach ($allowedVideoIds as $ids) {
            $this->allowedVideoIds[] = $ids['id'];
        }

        if (array_key_exists(array_search($this->id, $this->allowedVideoIds) + 1, $this->allowedVideoIds)) {
            $this->nextVideoId = $this->allowedVideoIds[array_search($this->id, $this->allowedVideoIds) + 1];
        }
    }
]);

$redirectTo = function ($path, $id) {
    session()->flash('videos-id', $id);
    $this->redirectRoute($path, navigate: true);
};

$redirectToNextVideo = function ($path, $id) {
    $data = ['video-player-id' => $id, 'allowedVideoIds' => $this->allowedVideoIds];
    session()->flash('video-player-id', $data);
    $this->redirectRoute($path, navigate: true);
};

mount(function ($data) {
    $this->id = $data['video-player-id'];
    $video =  Video::find($this->id);
    $this->url = $video->video;
    $this->name = $video->name;
    $this->program_id = $video->program_id;
    $this->allowedVideoIds = $data['allowedVideoIds'];

    if (array_key_exists(array_search($video->id, $this->allowedVideoIds) + 1, $this->allowedVideoIds)) {
        $this->nextVideoId = $this->allowedVideoIds[array_search($video->id, $this->allowedVideoIds) + 1];
    }
});

?>

<div class="bg-[#d6dcde] dark:bg-gray-800 h-full p-6 rounded-2xl grid grid-cols-1 gap-8">
    <div class="text-center text-[#131e30] dark:text-[#DDE6ED] text-3xl font-semibold">{{$name}}</div>
    <div x-init="$refs.myVideo.addEventListener('ended', () => { Livewire.dispatch('video-completed'); })" class="w-full">
        <video x-ref="myVideo" class="h-96 w-full rounded-2xl" controls autoplay controlsList="nodownload">
            <source src="{{asset('storage/'.$url)}}" type="video/mp4">
            <source src="{{asset('storage/'.$url)}}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="w-full flex justify-center">
        <div class="flex justify-between gap-4">
            <div wire:click="redirectTo('videos',{{$program_id}})" class="bg-[#131e30] dark:bg-[#DDE6ED] w-min px-8 cursor-pointer py-4 text-lg font-semibold rounded-lg text-[#d6dcde] dark:text-[#131e30]">Back</div>
            @if($nextVideoId)
            <div wire:click="redirectToNextVideo('video-player',{{$nextVideoId}})" class="bg-[#131e30] dark:bg-[#DDE6ED] w-min px-8 cursor-pointer py-4 text-lg font-semibold rounded-lg text-[#d6dcde] dark:text-[#131e30]">Next</div>
            @endif
        </div>
    </div>
</div>