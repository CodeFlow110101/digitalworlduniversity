<?php

use App\Models\Program;

use function Livewire\Volt\{state, with, on, placeholder};



with(['programs' => Program::paginate(0)]);

$redirectTo = function ($path, $id) {
    session()->flash('videos-id', $id);
    $this->redirectRoute($path, navigate: true);
};

?>

<div class="h-dvh">
    <div class="h-full gap-6 p-6 grid grid-cols-4">
        @foreach($programs as $program)
        <div class="grow h-1/2 flex flex-col gap-2">
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
                <div class="absolute inset-1 p-2 bg-black rounded-3xl overflow-hidden">
                    <img wire:click="$dispatch('show-modal', { modal:'modal-program-preview', args:{{$program->id}}, data:null, callback_event:null })" src="{{asset('storage/'.$program->image)}}" class="size-full rounded-3xl">
                </div>
            </div>
            <button wire:click="redirectTo('video',{{$program->id}})" class="bg-black bg-gradient-to-bl font-semibold from-transparent via-white rounded-full py-2 px-4 text-sm mx-auto">Start Now</button>
        </div>
        @endforeach
    </div>
</div>