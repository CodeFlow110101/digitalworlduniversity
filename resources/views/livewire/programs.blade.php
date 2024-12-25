<?php

use App\Models\Program;

use function Livewire\Volt\{state, with, on, placeholder};



with(['programs' => Program::with(['status'])->get()]);

$redirectTo = function ($path, $id) {
    session()->flash('videos-id', $id);
    $this->redirectRoute($path, navigate: true);
};

?>

<div class="h-dvh relative" x-data="{ height: 0 , tabHeight: 0}" x-resize="height = $height">
    <div class="gap-2 lg:gap-6 p-2 lg:p-6 grid grid-cols-2 sm:grid-cols-4 overflow-y-auto" :style="'height: ' + height + 'px;'">
        @foreach($programs as $program)
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
                    <div class="size-full relative">
                        <img wire:click="$dispatch('show-modal', { modal:'modal-program-preview', args:{{$program->id}}, data:null, callback_event:null })" src="{{ $program->image_url}}" class="size-full rounded-3xl">
                        @if($program->status->name == 'coming soon')
                        <div class="absolute inset-0 bg-black/50 flex justify-center items-center">
                            <svg class="size-1/2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.2" d="M9 11V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @if($program->status->name == 'started')
            <button wire:click="redirectTo('video',{{$program->id}})" class="bg-black bg-gradient-to-bl font-semibold from-transparent via-white rounded-full py-2 px-4 text-sm mx-auto">Start Now</button>
            @endif
        </div>
        @endforeach
    </div>
    <div class="text-white bg-white absolute inset-0 p-2 lg:p-6 flex flex-col gap-2 lg:gap-6 opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>