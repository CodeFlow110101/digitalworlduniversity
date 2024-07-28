<?php

use App\Models\Video;

use function Livewire\Volt\{state, mount};

state(['id', 'url', 'name', 'program_id']);

$redirectTo = function ($path, $id) {
    session()->flash('admin-panel-video-id', $id);
    $this->redirectRoute($path, navigate: true);
};

mount(function ($data) {
    $this->id = $data['video-player-id'];
    $video =  Video::find($this->id);
    $this->url = $video->video;
    $this->name = $video->name;
    $this->program_id = $video->program_id;
});

?>

<div class="bg-[#d6dcde] dark:bg-gray-800 h-full p-6 rounded-2xl grid grid-cols-1 gap-8">
    <div class="text-center text-[#131e30] dark:text-[#DDE6ED] text-3xl font-semibold">{{$name}}</div>
    <div class="w-full">
        <video class="h-96 w-full rounded-2xl" controls autoplay controlsList="nodownload">
            <source src="{{asset('storage/'.$url)}}" type="video/mp4">
            <source src="{{asset('storage/'.$url)}}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="w-full flex justify-center">
        <div wire:click="redirectTo('admin-panel-videos',{{$program_id}})" class="bg-[#131e30] dark:bg-[#DDE6ED] w-min px-8 cursor-pointer py-4 text-lg font-semibold rounded-lg text-[#d6dcde] dark:text-[#131e30]">Back</div>
    </div>
</div>