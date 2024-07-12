<?php

use App\Models\Channel;

use function Livewire\Volt\{state, mount};

state(['channels', 'current_channel']);

mount(function () {
    $this->channels = Channel::get();
    $this->current_channel = Channel::first()->id;
});

?>

<div wire:poll.2s class="lg:flex lg:justify-between gap-8 text-[#131e30] max-lg:grid max-lg:grid-cols-1 max-lg:gap-4">
    <div class="bg-[#d6dcde] rounded-2xl py-4 h-full w-full grid grid-cols-1 gap-2">
        <div class="text-center py-4 sm:py-8 font-bold text-2xl">Channels</div>
        <div class="bg-[#b5c1c9] rounded-2xl m-4 p-4 overflow-auto max-h-48 lg:max-h-[550px]">
            @foreach($channels as $channel)
            <div wire:click="$set('current_channel',{{$channel->id}})" wire:key="channel{{ $channel->id }}" class="py-4 cursor-pointer sm:py-6 my-4 font-semibold rounded-full h-min text-center @if($channel->id == $current_channel) bg-[#131e30] text-[#fafbfb] @else bg-[#d6dcde] hover:bg-[#131e30] hover:text-[#fafbfb] @endif">
                {{$channel->name}}
            </div>
            @endforeach
        </div>
    </div>
    <div class="bg-[#d6dcde] rounded-2xl h-full w-full">
        <div class="bg-[#d6dcde] rounded-2xl pt-4 pb-1 h-full w-full grid grid-cols-1 gap-2">
            <div class="text-center py-4 sm:py-8 font-bold text-2xl">{{Channel::find($current_channel)->name}}</div>
            <div class="bg-[#b5c1c9] rounded-2xl m-4 p-4 overflow-auto max-h-96 lg:max-h-[480px]">
                @for($i=1;$i<=10;$i++)
                    <div wire:key="chat{{ $i }}" class="w-full flex justify-end">
                    <div class="py-2 px-6 my-2 sm:my-3 rounded-2xl text-wrap w-4/5 bg-[#d6dcde]">
                        message {{$i}}
                    </div>
            </div>
            @endfor
        </div>
        <div class="w-full px-4 pb-4 relative">
            <input class="pl-4 pr-14 py-4 w-full rounded-2xl bg-[#b5c1c9] outline-none font-semibold">
            <div class="absolute right-8 top-3 cursor-pointer p-1 rounded-full bg-[#131e30]">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
</div>
</div>