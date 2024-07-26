<?php

use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, on, placeholder, usesPagination};

usesPagination();

state(['channels', 'current_channel', 'user_id', 'message']);

$setChannel = function ($id) {
    $this->current_channel = Channel::find($id);
};



mount(function () {
    $this->channels = Channel::get();
    $this->current_channel = Channel::first();
    $this->user_id = Auth::user()->id;
});

?>

<div class="rounded-2xl bg-[#d6dcde] text-[#131e30]">
    <div class="h-full w-full flex justify-between relative">
        <div class="rounded-2xl pt-4 p-4 h-full w-fit gap-2 sm:gap-4">
            <div class="bg-[#d6dcde] rounded-2xl h-full grid grid-cols-1 gap-2">
                <div class="bg-[#b5c1c9] rounded-2xl w-min pr-4 overflow-auto no-scrollbar h-[700px] flex justify-center">
                    <div class="w-full">
                        @foreach($channels as $channel)
                        <div class="flex justify-between gap-2 items-center w-min">
                            <div class="bg-red-500 w-0 @if($channel->id == $current_channel->id) h-8 sm:h-10 @else h-3 @endif border-l-4 rounded-r-full border-[#131e30]"></div>
                            <div wire:click="setChannel({{$channel->id}})" wire:key="channel{{ $channel->id }}" class="w-10 h-10 sm:w-20 sm:h-20 max-sm:text-sm my-4 cursor-pointer flex items-center justify-center font-semibold rounded-full text-center @if($channel->id == $current_channel->id) bg-[#131e30] text-[#fafbfb] @else bg-[#d6dcde] hover:bg-[#131e30] hover:text-[#fafbfb] @endif">
                                {{$channel->name[0]}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute h-[700px] flex justify-between gap-2">
            <div class="w-32"></div>
            <livewire:chat :current_channel="$current_channel" :user_id="$user_id">
        </div>
    </div>
</div>