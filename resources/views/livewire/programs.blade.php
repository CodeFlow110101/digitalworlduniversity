<?php

use App\Models\Program;

use function Livewire\Volt\{state, with, on};

with(['programs' => Program::paginate(0)]);

$redirectTo = function ($path, $id) {
    session()->flash('admin-panel-video-id', $id);
    $this->redirectRoute($path, navigate: true);
};

?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($programs as $program)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <svg class="w-10 h-10 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                </svg>
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$program->title}}</div>
                <div class="font-semibold text-md capitalize">{{$program->description}}</div>
            </div>
            <div class="text-[#d6dcde] pointer-events-none rounded-b-2xl bg-[#131e30] text-center p-3 grid grid-cols-1 gap-1 text-lg font-bold cursor-pointer">
                <div wire:click="redirectTo('videos',{{$program->id}})" class="w-full rounded-b-2xl text-center py-2 h-1/2">
                    Videos
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>