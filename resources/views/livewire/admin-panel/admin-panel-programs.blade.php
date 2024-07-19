<?php

use App\Models\Program;
use App\Models\Video;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, with, on, placeholder};

placeholder('<div class="w-full h-96 mt-10 flex justify-center items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-white animate-spin fill-[#131e30]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>');

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
    VideoProgress::where('program_id', $id)->delete();
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