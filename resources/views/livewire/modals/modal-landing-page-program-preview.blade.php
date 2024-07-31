<?php

use App\Models\Program;
use function Livewire\Volt\{state, mount};

state(['program']);

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

mount(function ($modal, $args, $data, $callback_event) {
    $this->program = Program::find($args);
});
?>

<div>
    <div class="bg-black rounded-2xl grid grid-cols-1 gap-4">
        <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
            <img src="{{asset('storage/'.$program->image)}}" class="w-full h-full rounded-t-2xl">
        </div>
        <div class="p-4 text-[#f6aa23] grid grid-cols-1 gap-4">
            <div class="font-semibold text-2xl">{{$program->title}}</div>
            <div class="font-semibold text-md capitalize">{{$program->description}}</div>
        </div>
        <div wire:click="redirectTo('sign-up')" class="text-[#d6dcde] rounded-b-2xl bg-[#131e30] text-center p-3 grid grid-cols-1 gap-1 text-lg font-bold cursor-pointer">
            <div class="w-full rounded-b-2xl text-center text-[#f6aa23] py-2 h-1/2">
                Join
            </div>
        </div>
    </div>
</div>