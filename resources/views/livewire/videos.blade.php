<?php

use App\Models\Program;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount, with, on, placeholder};

state(['id', 'allowedVideoIds']);



with(fn() => ['videos' => Video::where('program_id', $this->id)->get()]);

$redirectTo = function ($path, $id) {
    $data = ['video-player-id' => $id, 'allowedVideoIds' => $this->allowedVideoIds];
    session()->flash('video-player-id', $data);
    $this->redirectRoute($path, navigate: true);
};

mount(function ($id) {
    $this->id = $id;
    $user_video_progress = VideoProgress::select('video_id')->where('user_id', Auth::user()->id)->where('program_id', $this->id)->get()->toArray();
    $allVideoIds = Video::select('id')->where('program_id', $this->id)->get()->toArray();

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
});
?>

<div class="h-dvh relative" x-data="{ height: 0 , tabHeight: 0}" x-resize="height = $height">
    <div class="gap-6 p-6 grid grid-cols-2 sm:grid-cols-4 overflow-y-auto" :style="'height: ' + height + 'px;'">
        @foreach($videos as $video)
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl grid grid-cols-1 gap-4 hidden">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{ $video->thumbnail_url }}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] dark:text-[#DDE6ED] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$video->name}}</div>
            </div>
            @if($loop->first || in_array($video->id, $allowedVideoIds))
            <div wire:click="redirectTo('video-player',{{$video->id}})" class="text-[#d6dcde] bg-[#131e30] cursor-pointer rounded-b-2xl text-center py-3 text-lg font-bold">Watch</div>
            @else
            <div class="text-[#d6dcde] bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold flex justify-center cursor-not-allowed">
                <svg class="w-6 h-6 text-[#d6dcde]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd" />
                </svg>
            </div>
            @endif
        </div>
        <div class="flex flex-col gap-2" :style="'height: ' + tabHeight + 'px;'">
            <div class="relative grow rounded-3xl overflow-hidden">
                <div class="size-full flex flex-col">
                    <div class="grow flex justify-stretch">
                        <div class="bg-gradient-to-br from-white via-transparent via-35% size-full"></div>
                        <div class="bg-gradient-to-bl from-white via-transparent via-35% size-full"></div>
                    </div>
                    <div class="grow flex justify-stretch">
                        <div class="bg-gradient-to-tr from-white via-transparent via-35% size-full"></div>
                        <div class="bg-gradient-to-tl from-white via-transparent via-35% size-full"></div>
                    </div>
                </div>
                <div class="absolute inset-0.5 p-1 bg-black rounded-3xl overflow-hidden">
                    <div class="relative rounded-3xl size-full">
                        <img src="{{ $video->thumbnail_url }}" class="size-full rounded-3xl">
                        @if($loop->first || in_array($video->id, $allowedVideoIds))
                        <button wire:click="redirectTo('video-player',{{$video->id}})" class="absolute inset-0 rounded-3xl hover:bg-black/50 flex flex-col p-12 transition-colors duration-200 group">
                            <svg class="size-full text-white opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.2" d="M8 18V6l8 6-8 6Z" />
                            </svg>
                        </button>
                        @else
                        <div wire:click="redirectTo('video-player',{{$video->id}})" class="absolute inset-0 rounded-3xl bg-black/50 flex flex-col p-12 transition-colors duration-200 group">
                            <svg class="size-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.2" d="M9 11V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-white bg-white absolute inset-0 p-6 flex flex-col gap-6 opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>