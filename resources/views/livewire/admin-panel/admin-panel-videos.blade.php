<?php

use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, on, placeholder};

state(['program_id']);



with(fn() => ['videos' => Video::where('program_id', $this->program_id)->paginate(0)]);

on([
    'reset-admin-panel-videos' => function () {
        $this->reset();
    }
]);

$redirectTo = function ($path, $id) {
    session()->flash('admin-panel-video-player-id', $id);
    $this->redirectRoute($path, navigate: true);
};

$deleteVideo = function ($id) {
    $video = Video::find($id);
    Storage::disk('public')->delete($video->video);
    Storage::disk('public')->delete($video->thumbnail);
    VideoProgress::where('video_id', $id)->delete();
    Video::find($id)->delete();
    session()->flash('admin-panel-video-id', $this->program_id);
    $this->redirectRoute('admin-panel-videos', navigate: true);
};

mount(function ($id) {
    $this->program_id = $id;
});
?>

<div>
    <button wire:click="$dispatch('show-modal', { modal:'modal-video', args:{{$program_id}}, data:null, callback_event:null })" class="fixed z-10 bottom-12 right-12 hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
        <div>
            <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M14 7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7Zm2 9.387 4.684 1.562A1 1 0 0 0 22 17V7a1 1 0 0 0-1.316-.949L16 7.613v8.774Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="text-[#131e30] font-semibold">
            Add Video
        </div>
    </button>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($videos as $video)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$video->thumbnail)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$video->name}}</div>
            </div>
            <div class="text-[#d6dcde] rounded-b-2xl bg-[#131e30] text-center p-3 grid grid-cols-1 gap-1 text-lg font-bold cursor-pointer">
                <div class="flex justify-between items py-2 center">
                    <div wire:click="redirectTo('admin-panel-video-player',{{$video->id}})" class=" w-full">Watch</div>
                    <div class="w-0 h-full border border-[#d6dcde]"></div>
                    <div wire:click="deleteVideo({{$video->id}})" class="w-full">Delete</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>