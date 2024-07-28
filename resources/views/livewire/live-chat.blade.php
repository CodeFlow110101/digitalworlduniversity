<?php

use App\Models\Channel;
use App\Models\Chat;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, usesPagination};

usesPagination();

state(['channels', 'current_channel', 'current_group', 'user_id', 'message']);

with(function () {
    return ['groups' => Group::where('channel_id', $this->current_channel->id)->paginate(0)];
});

$setChannel = function ($id) {
    $this->current_channel = Channel::find($id);
    $this->current_group = Group::where('channel_id', $this->current_channel->id)->first();
};

$setGroup = function ($id) {
    $this->current_group = Group::find($id);
    $this->dispatch('show-chats');
};

mount(function () {
    $this->channels = Channel::get();
    $this->current_channel = Channel::first();
    $this->user_id = Auth::user()->id;
    $this->current_group = Group::where('channel_id', $this->current_channel->id)->first();
});

?>

<div x-on:show-chats="showChats=true" x-data="{showChats:false}" class="rounded-2xl p-2 bg-[#d6dcde] dark:bg-gray-800 text-[#131e30]">
    <div class="w-full flex justify-between gap-2 max-lg:relative h-[700px]">
        <div class="rounded-2xl h-full">
            <div class="rounded-2xl h-full">
                <div class="bg-[#b5c1c9] dark:bg-black rounded-2xl pr-4 overflow-y-auto no-scrollbar h-full flex justify-center">
                    <div>
                        @foreach($channels as $channel)
                        <div class="flex justify-between gap-2 items-center">
                            <div class="bg-red-500 w-0 @if($channel->id == $current_channel->id) h-8 sm:h-10 @else h-3 @endif border-l-4 rounded-r-full border-[#131e30] dark:border-[#b5c1c9]"></div>
                            <div wire:click="setChannel({{$channel->id}})" wire:key="channel{{ $channel->id }}" class="w-10 h-10 sm:w-16 sm:h-16 max-sm:text-sm my-4 cursor-pointer flex items-center justify-center font-semibold rounded-full text-center @if($channel->id == $current_channel->id) bg-[#131e30] text-[#fafbfb] dark:text-[#131e30] dark:bg-[#b5c1c9] @else bg-[#d6dcde] dark:bg-[#131e30] dark:text-[#d6dcde] dark:hover:text-[#131e30] dark:hover:bg-[#d6dcde] hover:bg-[#131e30] hover:text-[#fafbfb] @endif">
                                {{$channel->name[0]}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:w-min w-full whitespace-nowrap h-full">
            <div class="bg-[#b5c1c9] dark:bg-black h-full rounded-2xl text-[#131e30] dark:text-[#DDE6ED]">
                <div class="text-center px-4 w-full py-4 sm:py-8 font-thin text-4xl select-none">
                    {{$this->current_channel->name}}
                </div>
                <div class="h-full w-full pr-4 text-2xl overflow-y-auto no-scrollbar">
                    @foreach($groups as $group)
                    <div class="flex justify-between gap-2 items-center">
                        <div class="bg-red-500 w-0 @if($group->id == $current_group->id) h-8 sm:h-8 @else h-3 @endif border-l-4 rounded-r-full border-[#131e30] dark:border-[#b5c1c9]"></div>
                        <div wire:click="setGroup({{$group->id}})" class="@if($group->id == $current_group->id) bg-[#131e30] text-[#fafbfb] dark:text-[#131e30] dark:bg-[#b5c1c9] @else bg-[#d6dcde] dark:bg-[#131e30] dark:text-[#d6dcde] dark:hover:text-[#131e30] dark:hover:bg-[#b5c1c9] hover:bg-[#131e30] hover:text-[#fafbfb] @endif text-base px-6 py-2 my-2 max-lg:w-full rounded-2xl cursor-pointer"># | {{$group->name}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div :class="showChats?'max-lg:scale-x-100':'max-lg:scale-x-0'" class="max-lg:absolute max-lg:z-10 h-[700px] w-full max-lg:transition-transform max-lg:duration-200 max-lg:origin-right flex justify-between gap-2">
            @if($current_group)
            <livewire:chat :current_group="$current_group" :user_id="$user_id">
                @endif
        </div>
    </div>
</div>