<?php

use App\Models\Program;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount, with, on, placeholder};

state(['id', 'allowedVideoIds']);



with(fn() => ['videos' => Video::where('program_id', $this->id)->paginate(0)]);

$redirectTo = function ($path, $id) {
    session()->flash('video-player-id', $id);
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
        @endforeach
    </div>
</div>