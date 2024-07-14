<?php

use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;


use function Livewire\Volt\{state, mount, with, on};

state(['channels', 'current_channel', 'user_id', 'message']);

with(fn() => ['chats' => Chat::where('user_id', $this->user_id)->where('channel_id', $this->current_channel->id)->paginate(100)]);

$setChannel = function ($id) {
    $this->current_channel = Channel::find($id);
};

on(['send-message-backend' => function ($message, $isFileAttached, $file) {}]);

$sendMessage = function () {
    if ($this->message && rtrim($this->message) != "") {
        Chat::create(['user_id' => $this->user_id, 'message' => $this->message, 'channel_id' => $this->current_channel->id]);
        $this->reset(['message']);
    }
};

mount(function () {
    $this->channels = Channel::get();
    $this->current_channel = Channel::first();
    $this->user_id = Auth::user()->id;
});

?>

<div wire:poll.6s class="rounded-2xl bg-[#d6dcde] text-[#131e30]">
    <div class=" text-center py-8 font-thin text-4xl select-none">{{$this->current_channel->name}}</div>
    <div class="h-full w-full grid grid-cols-1 gap-4">
        <div class="rounded-2xl pt-4 p-4 h-full w-full flex justify-between gap-4">
            <div class="bg-[#d6dcde] rounded-2xl h-full grid grid-cols-1 gap-2">
                <div class="bg-[#b5c1c9] rounded-2xl w-min pr-4 overflow-auto no-scrollbar max-h-96 lg:max-h-[480px] flex justify-center">
                    <div class="w-full">
                        @foreach($channels as $channel)
                        <div class="flex justify-between gap-2 items-center w-min">
                            <div class="bg-red-500 w-0 @if($channel->id == $current_channel->id) h-10 @else h-3 @endif border-l-4 rounded-r-full border-[#131e30]"></div>
                            <div wire:click="setChannel({{$channel->id}})" wire:key="channel{{ $channel->id }}" class="w-14 h-14 sm:w-20 sm:h-20 my-4 cursor-pointer flex items-center justify-center font-semibold rounded-full text-center @if($channel->id == $current_channel->id) bg-[#131e30] text-[#fafbfb] @else bg-[#d6dcde] hover:bg-[#131e30] hover:text-[#fafbfb] @endif">
                                {{$channel->name[0]}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-full select-none">
                <div class=" rounded-2xl px-4 overflow-auto max-h-96 lg:max-h-[480px] grid grid-cols-1 gap-4 sm:gap-6">
                    @foreach($chats as $chat)
                    <div wire:key="chat{{ $chat->id }}" class="w-full flex justify-end">
                        <div class="py-1 sm:py-2 px-2 sm:px-6 rounded-xl sm:rounded-2xl text-wrap w-4/5 bg-[#b5c1c9]">
                            <div class="font-text-sx sm:font-normal"> {{$chat->message}}</div>
                            <div class="text-xs max-sm:hidden text-right">{{$chat->created_at}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div x-data="{isFileAttached:false}" class="w-full px-4 pb-4">
            <!-- <input x-ref="message" class="px-6 py-2 sm:py-4 w-full rounded-t-2xl bg-[#b5c1c9] outline-none font-semibold" placeholder="Message"> -->
            <input wire:model="message" class="px-6 py-2 sm:py-4 w-full rounded-t-2xl bg-[#b5c1c9] outline-none font-semibold" placeholder="Message">
            <div class="flex justify-between bg-[#b5c1c9] rounded-b-2xl p-2 sm:p-4">
                <div class="w-min flex justify-between gap-4 relative">
                    <div @click="$refs.fileField.click()" class="hover:bg-gray-300 cursor-pointer p-1 rounded-full bg-transparent">
                        <svg class="w-6 h-6 rotate-45 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" />
                        </svg>
                        <div x-cloak x-show="isFileAttached" class="top-0 left-6 absolute w-4 h-4 bg-green-400 border-2 border-black text-white rounded-full"></div>
                    </div>
                    <div x-cloak x-show="isFileAttached" @click="$refs.fileField.value = null; isFileAttached = false" class="cursor-pointer p-1 rounded-full bg-red-600">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                    </div>
                </div>
                <!-- <div wire:click="$dispatch('send-message', { message: $refs.message.value, isFileAttached:isFileAttached, file:$refs.fileField.files[0] })" class="cursor-pointer py-1 text-md text-center px-4 w-min text-white rounded-lg bg-[#131e30]"> -->
                <div wire:click="sendMessage" class="cursor-pointer py-1 text-md text-center px-4 w-min text-white rounded-lg bg-[#131e30]">
                    Send
                </div>
                <input @change="isFileAttached=$refs.fileField.value ? true : false" type="file" x-ref="fileField" class="hidden">
            </div>
        </div>
    </div>
</div>