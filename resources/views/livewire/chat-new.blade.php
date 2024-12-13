<?php

use App\Models\Channel;
use App\Models\Chat;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

use function Livewire\Volt\{state, mount, updated, with, action, rules};

state(['channel', 'group', 'message', 'file', 'user' => Auth::user()]);

rules(['message' => 'required_without:file', 'file' => 'required_without:message|max:5',]);

with(fn() => [
    'channels' => Channel::get(),
    'groups' => Group::where('channel_id', $this->channel ? $this->channel->id : null)->get(),
    'chats' => Chat::with(['user'])->where('group_id', $this->group ? $this->group->id : null)->orderBy('created_at', 'desc')->limit(20)->get()->reverse()
]);

$selectChannel = function ($id) {
    $this->channel = Channel::find($id);
};

$selectGroup = function ($id) {
    $this->js("Echo.leaveChannel('group." . (string)$this->group->id . "');");
    $this->group = Group::find($id);
};

$send = action(function () {
    $this->validate();

    $message = Chat::create([
        'user_id' => $this->user->id,
        'message' => $this->message,
        'group_id' => $this->group->id,
    ]);

    Broadcast::on('group.' . $this->group->id)->as('chat')->with(['message' => Chat::with(['user'])->find($message->id)])->sendNow();

    $this->reset(['message']);
})->renderless();

mount(function () {
    dd(env('REVERB_APP_ID'),env('REVERB_APP_KEY'),env('REVERB_APP_SECRET'),env('REVERB_HOST'),env('REVERB_PORT'),env('REVERB_SCHEME'));
    $this->channel = Channel::count() != 0 ? Channel::first() : null;
    $this->group = $this->channel && Group::where('channel_id', $this->channel->id)->count() != 0 ? Group::where('channel_id', $this->channel->id)->first() : null;
});
?>

<div x-data="chat()" x-init="chats = Object.values({{$chats}}); user = {{$user}}; groupId = {{$this->group->id}}; init();" class="text-white grow flex justify-between p-4 gap-4">
    <div class="w-[10%] rounded-lg border border-white pr-2 py-2 flex flex-col">
        <div class="grow overflow-y-auto relative gap-4 my-auto rounded-lg" x-data="{ height: 0 }" x-resize="height = $height">
            <div :style="'height: ' + height + 'px;'" class="absolute inset-x-0 flex flex-col gap-4">
                @foreach($channels as $channel)
                <div wire:click="selectChannel({{$channel->id}})" class="flex justify-between items-center gap-1 w-full">
                    <div class="@if($channel->id == $this->channel->id) h-1/2 @else h-4 @endif w-0 border-2 rounded-r-full border-white"></div>
                    <div class="w-full">
                        <img class="w-full aspect-square rounded-md" src="{{asset('storage/'.$channel->thumbmail)}}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="size-full flex justify-between gap-4">
        <div class="w-4/12 p-4 flex flex-col justify-around border border-white rounded-lg gap-4">
            <div class="text-black p-2 text-center rounded-md bg-white">{{$this->channel->name}}</div>
            <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
                <div class="absolute overflow-y-auto flex flex-col gap-4 inset-0" :style="'height: ' + height + 'px;'">
                    @foreach($groups as $group)
                    <button wire:click="selectGroup({{$group->id}})" class="@if($group->id == $this->group->id) bg-white text-black @else bg-black/80 text-white hover:bg-white hover:text-black @endif transition-colors duration-200 w-min break-words whitespace-nowrap py-2 px-4 rounded-md"># | {{$group->name}}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full rounded-tr-lg rounded-br-lg overflow-hidden flex flex-col border border-white rounded-lg p-2">
            <div class="bg-black text-center py-4 text-lg align-middle"># | {{$this->group->name}}</div>
            <div class="size-full flex flex-col justify-end">
                <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
                    <div class="p-4 overflow-y-auto flex flex-col-reverse gap-4 absolute inset-x-0" :style="'height: ' + height + 'px;'">
                        <template x-for="chat in chats" :key="chat.id">
                            <div :class="chat.user_id == user.id ? 'ml-auto' : 'mr-auto flex-row-reverse'" class="break-words text-wrap min-w-0 max-w-[70%] flex items-center gap-1">
                                <div class="flex flex-col">
                                    <div :class="chat.user_id == user.id || 'flex-row-reverse'" class="flex gap-2 items-center">
                                        <div class="text-xs" x-text="getTimestamp(chat.created_at)"></div>
                                        <div class="font-semibold text-xl" x-text="chat.user.name"></div>
                                    </div>
                                    <div :class="chat.user_id == user.id ? 'text-right' : 'text-left'" class="break-words text-wrap rounded-md p-2" x-text="chat.message"></div>
                                </div>
                                <div class="h-full py-3">
                                    <svg class="size-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div>
                <form wire:submit="send" class="flex justify-between items-center gap-2 p-2">
                    <div class="rounded-lg border border-white w-full gap-2 relative">
                        <div x-show="fileName" class="absolute bottom-0 inset-x-0 text-white pointer-events-none">
                            <div class="rounded-lg border border-white size-full bg-black flex justify-between items-center -translate-y-full py-0.5 px-2">
                                <div class="flex justify-start items-center w-full gap-2">
                                    <div class="flex items-center">
                                        <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                        </svg>
                                        <div x-text="fileName.length > 20 ? fileName.slice(0, 20) + '...' : fileName"></div>
                                    </div>
                                    <div class="text-red-500 font-normal text-sm" x-text="$wire.file > 5 ? 'File size must be less than 5 MB' : ''"></div>
                                </div>
                                <div @click="$refs.file.value = null; $refs.file.dispatchEvent(new Event('change'));" class="w-min hover:bg-white pointer-events-auto rounded-full p-1 group transition-colors duration-200">
                                    <svg class="w-6 h-6 text-white group-hover:text-black transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input wire:model="message" class="w-full p-2 text-white bg-transparent pr-12 outline-none" placeholder="Type here...">
                        <input x-ref="file" type="file" @change="handleFileSelect" class="hidden">
                        <input wire:model="file" class="bg-black hidden">
                        <div class="absolute top-0 bottom-0 right-2 flex items-center">
                            <div @click="$refs.file.click()" class="hover:bg-white rounded-full group duration-200 pointer-events-none">
                                <svg class="w-8 h-8 text-white group-hover:text-black duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="p-2 rounded-full bg-black group hover:bg-white transition-colors duration-200 border border-white">
                        <svg class="w-6 h-6 text-white group-hover:text-black transition-colors duration-200 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 18-7 3 7-18 7 18-7-3Zm0 0v-5" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>