<?php

use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;


use function Livewire\Volt\{state, mount, with};

state(['channels', 'current_channel', 'user_id', 'message']);

with(fn() => ['chats' => Chat::where('user_id', $this->user_id)->where('channel_id', $this->current_channel->id)->paginate(100)]);

$setChannel = function ($id) {
    $this->current_channel = Channel::find($id);
};

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

<div wire:poll.6s class="gap-8 rounded-2xl bg-[#d6dcde] text-[#131e30] max-lg:grid max-lg:grid-cols-1 max-lg:gap-4">
    <div class=" flex justify-between h-full w-full">
        <div class="bg-[#d6dcde] rounded-2xl py-4 h-full grid grid-cols-1 gap-2">
            <div class="text-center py-4 sm:py-8 font-bold text-2xl invisible">Messages</div>
            <div class="bg-[#b5c1c9] rounded-2xl m-4 pr-4 w-28 overflow-auto h-full max-h-[460px] lg:max-h-[550px] flex justify-center">
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
        <div class="bg-[#d6dcde] rounded-2xl pt-4 pb-1 h-full w-full grid grid-cols-1 gap-2">
            <div class="text-center py-4 sm:py-8 font-bold text-2xl">{{$this->current_channel->name}}</div>
            <div class="bg-[#b5c1c9] rounded-2xl m-4 p-4 overflow-auto max-h-96 lg:max-h-[480px]">
                @foreach($chats as $chat)
                <div wire:key="chat{{ $chat->id }}" class="w-full flex justify-end">
                    <div class="py-1 sm:py-2 px-2 sm:px-6 my-2 sm:my-3 rounded-xl sm:rounded-2xl text-wrap w-4/5 bg-[#d6dcde]">
                        <div class="font-text-sx sm:font-normal"> {{$chat->message}}</div>
                        <div class="text-xs max-sm:hidden text-right">{{$chat->created_at}}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="w-full px-4 pb-4 relative">
                <input wire:model="message" class="pl-4 pr-14 py-4 w-full rounded-2xl bg-[#b5c1c9] outline-none font-semibold">
                <div wire:click="sendMessage" class="absolute right-8 top-3 cursor-pointer p-1 rounded-full bg-[#131e30]">
                    <svg class="w-6 h-6  text-[#fafbfb]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>