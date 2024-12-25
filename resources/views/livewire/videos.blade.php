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
    <div x-data class="gap-2 lg:gap-6 p-2 lg:p-6 grid grid-cols-2 sm:grid-cols-4 overflow-y-auto" :style="'height: ' + height + 'px;'">
        @foreach($videos as $video)
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
    <div class="text-white bg-white absolute inset-0 gap-2 lg:gap-6 p-2 lg:p-6 flex flex-col opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>