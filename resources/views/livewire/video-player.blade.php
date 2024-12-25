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

<div class="bg-white dark:bg-black h-full p-6 rounded-2xl grid grid-cols-1 gap-8">
    <div class="text-center text-blcak dark:text-white text-3xl font-semibold">{{$name}}</div>
    <iframe x-data="vimeoPlayer" x-ref="vimeoplayer" src="{{ 'https://player.vimeo.com/video/' . $url }}" class="w-full" width="848" height="478" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="Untitled"></iframe>
    <div class="w-full flex justify-center">
        <div class="flex justify-between gap-4 h-min">
            <div wire:click="redirectTo('video',{{$program_id}})" class="bg-[#131e30] dark:bg-[#DDE6ED] w-min px-8 cursor-pointer py-4 text-lg font-semibold rounded-lg text-[#d6dcde] dark:text-[#131e30]">Back</div>
            @if($nextVideoId)
            <div wire:click="redirectToNextVideo('video-player',{{$nextVideoId}})" class="bg-[#131e30] dark:bg-[#DDE6ED] w-min px-8 cursor-pointer py-4 text-lg font-semibold rounded-lg text-[#d6dcde] dark:text-[#131e30]">Next</div>
            @endif
        </div>
    </div>
</div>