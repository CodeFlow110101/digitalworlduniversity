<?php

use App\Models\Program;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, with, on};

with(['programs' => Program::paginate(0)]);

on([
    'reset-admin-panel-programs' => function () {
        $this->reset();
    }
]);

$redirectTo = function ($path, $id) {
    session()->flash('admin-panel-video-id', $id);
    $this->redirectRoute($path, navigate: true);
};

$deleteProgram = function ($id) {
    $videos = Video::where('program_id', $id)->get();
    foreach ($videos as $video) {
        Storage::disk('public')->delete($video->video);
        Storage::disk('public')->delete($video->thumbnail);
    }
    Storage::disk('public')->delete(Program::find($id)->image);
    Video::where('program_id', $id)->delete();
    Program::where('id', $id)->delete();
    $this->redirectRoute('admin-panel-programs', navigate: true);
};

?>

<div>
    <button wire:click="$dispatch('show-modal', { modal:'modal-programs', args:null, data:null, callback_event:null })" class="fixed z-10 bottom-12 right-12 hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
        <div>
            <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="text-[#131e30] font-semibold">
            Add Program
        </div>
    </button>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($programs as $program)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$program->image)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$program->title}}</div>
                <div class="font-semibold text-md capitalize">{{$program->description}}</div>
            </div>
            <div class="text-[#d6dcde] rounded-b-2xl bg-[#131e30] text-center p-3 grid grid-cols-1 gap-1 text-lg font-bold cursor-pointer">
                <div class="flex justify-between items py-2 center">
                    <div wire:click="$dispatch('show-modal', { modal:'modal-programs', args:{{$program->id}}, data:null, callback_event:null })" class="w-full pointer-events-none">Edit</div>
                    <div class="w-0 h-full border border-[#d6dcde]"></div>
                    <div wire:click="deleteProgram({{$program->id}})" class="w-full">Delete</div>
                </div>
                <div class="w-full h-0 border border-[#d6dcde]"></div>
                <div wire:click="redirectTo('admin-panel-videos',{{$program->id}})" class="w-full rounded-b-2xl text-center py-2 h-1/2">
                    Videos
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>