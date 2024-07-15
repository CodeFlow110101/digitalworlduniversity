<?php

use App\Models\Job;
use function Livewire\Volt\{state, rules};
use Illuminate\Support\Facades\Auth;

state(['title', 'description', 'image', 'url']);

rules(['title' => 'required|min:6', 'description' => 'required|min:6', 'image' => 'required', 'url' => 'required']);

$submit = function () {

    $this->validate();

    Job::create([
        'title' => $this->title,
        'description' => $this->description,
        'image' => $this->image,
        'url' => $this->url,
        'created_by' => Auth::user()->id,
    ]);

    $this->dispatch('hide-modal');
    $this->dispatch('reset-find-jobs-page');
};
?>

<div>
    <div class="w-full h-min grid grid-cols-1 gap-6">
        <div>
            <div class=" relative">
                <input wire:model="title" type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-[#131e30] bg-transparent rounded-lg border-2 border-[#131e30] appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <label for="floating_outlined" class="absolute text-sm text-[#131e30] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#d6dcde] px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Title</label>
            </div>
            @error('title')<div class="text-red-600">{{$message}}</div>@enderror
        </div>
        <div>
            <div class="relative">
                <input wire:model="description" type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-[#131e30] bg-transparent rounded-lg border-2 border-[#131e30] appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <label for="floating_outlined" class="absolute text-sm text-[#131e30] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#d6dcde] px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Description</label>
            </div>
            @error('description')<div class="text-red-600">{{$message}}</div>@enderror
        </div>
        <div>
            <div class="relative">
                <input wire:model="image" type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-[#131e30] bg-transparent rounded-lg border-2 border-[#131e30] appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <label for="floating_outlined" class="absolute text-sm text-[#131e30] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#d6dcde] px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Image</label>
            </div>
            @error('image')<div class="text-red-600">{{$message}}</div>@enderror
        </div>
        <div>
            <div class="relative">
                <input wire:model="url" type="text" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-[#131e30] bg-transparent rounded-lg border-2 border-[#131e30] appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <label for="floating_outlined" class="absolute text-sm text-[#131e30] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#d6dcde] px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Form Link</label>
            </div>
            @error('url')<div class="text-red-600">{{$message}}</div>@enderror
        </div>
        <div class="flex justify-center w-full">
            <button wire:click="submit" class="bg-[#131e30] px-8 py-4 text-lg font-semibold rounded-lg text-[#d6dcde]">Submit</button>
        </div>
    </div>
</div>