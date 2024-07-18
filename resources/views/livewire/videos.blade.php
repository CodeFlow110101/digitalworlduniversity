<?php

use App\Models\Video;

use function Livewire\Volt\{state, mount, with, on};

state(['id']);

with(fn() => ['videos' => Video::where('program_id', $this->id)->paginate(0)]);

$redirectTo = function ($path, $id) {
    session()->flash('video-player-id', $id);
    $this->redirectRoute($path, navigate: true);
};

mount(function ($id) {
    $this->id = $id;
});
?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($videos as $video)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$video->thumbnail)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$video->name}}</div>
            </div>
            <div wire:click="redirectTo('video-player',{{$video->id}})" class="text-[#d6dcde] bg-[#131e30] cursor-pointer rounded-b-2xl text-center py-3 text-lg font-bold">Watch</div>
        </div>
        @endforeach
    </div>
</div>