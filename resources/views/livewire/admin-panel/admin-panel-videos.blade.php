<?php

use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, on, placeholder};

state(['program_id']);

placeholder('<div class="w-full h-96 mt-10 flex justify-center items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-white animate-spin fill-[#131e30]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>');

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