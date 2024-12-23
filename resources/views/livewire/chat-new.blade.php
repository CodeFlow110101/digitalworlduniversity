<?php

use App\Models\Channel;
use App\Models\Chat;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Storage;

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


$getPreviousChats = action(function ($id) {
    return Chat::with(['user'])->where('group_id', $this->group->id)->where('id', '<', $id)->orderBy('id', 'desc')->limit(20)->get();
})->renderless();

$recieveUploadedFile = action(function ($name, $url, $path) {
    $this->createChat($name, $url, $path);
})->renderless();

$createChat = action(function ($name, $url, $path) {
    $message = Chat::create([
        'user_id' => $this->user->id,
        'message' => $this->message,
        'group_id' => $this->group->id,
        'file_name' => $name,
        'file_path' => $path,
        'file_url' => $url,
    ]);

    Broadcast::on('group.' . $this->group->id)->as('chat')->with(['message' => Chat::with(['user'])->find($message->id)])->sendNow();
    $this->dispatch('reset-file');
    $this->reset(['message']);
})->renderless();


$send = action(function () {
    $this->validate();

    if (isset($this->file)) {
        $this->dispatch('upload-file');
    } else {
        $this->createChat(null, null, null);
    }
})->renderless();

$downloadFile = action(function ($filePath, $fileName) {
    return Storage::disk('s3')->download($filePath, $fileName);
})->renderless();

mount(function () {
    $this->channel = Channel::count() != 0 ? Channel::first() : null;
    $this->group = $this->channel && Group::where('channel_id', $this->channel->id)->count() != 0 ? Group::where('channel_id', $this->channel->id)->first() : null;
});
?>

<div x-data="chat()" x-init="chats = Object.values({{$chats}}); user = {{$user}}; groupId = {{ $this->group ? $this->group->id : 0}}; init();" class="text-white grow flex justify-between p-4 gap-4">
    <div class="w-[10%] rounded-lg border dark:border-white border-black pr-2 py-2 flex flex-col">
        <div class="grow overflow-y-auto relative gap-4 my-auto rounded-lg" x-data="{ height: 0 }" x-resize="height = $height">
            <div :style="'height: ' + height + 'px;'" class="absolute inset-x-0 flex flex-col gap-4">
                @foreach($channels as $channel)
                <div wire:click="selectChannel({{$channel->id}})" class="flex justify-between items-center gap-1 w-full">
                    <div class="@if($channel->id == $this->channel->id) h-1/2 @else h-4 @endif w-0 border-2 rounded-r-full dark:border-white border-black"></div>
                    <div class="w-full">
                        <img class="w-full aspect-square rounded-md" src="{{asset('storage/'.$channel->thumbmail)}}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="size-full flex justify-between gap-4">
        <div class="w-4/12 p-4 flex flex-col justify-around border dark:border-white border-black rounded-lg gap-4">
            <div class="dark:text-black text-white p-2 text-center rounded-md dark:bg-white bg-black">{{ $this->channel ? $this->channel->name : '' }}</div>
            <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
                <div class="absolute overflow-y-auto flex flex-col gap-4 inset-0" :style="'height: ' + height + 'px;'">
                    @foreach($groups as $group)
                    <button wire:click="selectGroup({{$group->id}})" class="@if($group->id == $this->group->id) bg-black dark:text-black bg-black dark:bg-white @else dark:bg-black bg-white dark:text-white text-black hover:dark:bg-white hover:bg-black hover:text-white hover:dark:text-black  @endif transition-colors duration-200 w-min break-words whitespace-nowrap py-2 px-4 rounded-md"># | {{$group->name}}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full rounded-tr-lg rounded-br-lg overflow-hidden flex flex-col border dark:border-white border-black rounded-lg p-2">
            <div class="bg-black dark:bg-white text-white dark:text-black rounded-lg text-center py-4 text-lg align-middle"># | {{ $this->group ? $this->group->name : '' }}</div>
            <div class="size-full flex flex-col justify-end">
                <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
                    <div class="p-4 overflow-y-auto flex flex-col-reverse gap-4 absolute inset-x-0 dark:text-white text-black" x-on:scroll="checkScroll" x-ref="scrollContainer" :style="'height: ' + height + 'px;'">
                        <template x-for="chat in chats" :key="chat.id">
                            <div :class="chat.user_id == user.id ? 'ml-auto' : 'mr-auto flex-row-reverse'" class="break-words text-wrap min-w-0 max-w-[70%] flex items-center gap-1">
                                <div class="flex flex-col">
                                    <div :class="chat.user_id == user.id ? 'justify-end' : 'flex-row-reverse'" class="flex gap-2 items-center">
                                        <div class="text-xs" x-text="getTimestamp(chat.created_at)"></div>
                                        <div class="font-semibold text-xl" x-text="chat.user.name"></div>
                                    </div>
                                    <div :class="chat.user_id == user.id ? 'text-right' : 'text-left'" class="break-words text-wrap rounded-md p-2" x-text="chat.message"></div>
                                    <template x-if="chat.file_name">
                                        <div class="flex items-center gap-3 border dark:border-white border-black p-2 rounded-lg">
                                            <div>
                                                <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                                </svg>
                                            </div>
                                            <div class="text-xs" x-text="chat.file_name.length > 20 ? chat.file_name.slice(0, 20) + '...' : chat.file_name"></div>
                                            <button wire:click="downloadFile(chat.file_path,chat.file_name)" class=" hover:dark:bg-white hover:bg-black group transition-colors duration-200 p-0.5 rounded-full">
                                                <svg class="w-8 h-8 dark:text-white text-black group-hover:dark:text-black group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <div class="h-full py-3">
                                    <svg class="size-10 dark:text-white text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div wire:loading wire:target="getPreviousChats" class="absolute inset-x-0">
                        <div class="flex justify-center p-2">
                            <svg aria-hidden="true" class="w-8 h-8 text-transparent animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form wire:submit="send" class="flex justify-between items-center gap-2 p-2">
                    <div class="rounded-lg border dark:border-white border-black w-full gap-2 relative">
                        <div x-show="fileName" class="absolute bottom-0 inset-x-0 text-white pointer-events-none">
                            <div class="rounded-lg border dark:border-white border-black size-full dark:bg-black bg-white flex justify-between items-center -translate-y-full py-0.5 px-2">
                                <div class="flex justify-start items-center w-full gap-2">
                                    <div class="flex items-center">
                                        <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                        </svg>
                                        <div class="text-black dark:text-white" x-text="fileName.length > 20 ? fileName.slice(0, 20) + '...' : fileName"></div>
                                    </div>
                                    <div class="text-red-500 font-normal text-sm" x-text="$wire.file > 5 ? 'File size must be less than 5 MB' : ''"></div>
                                </div>
                                <div @click="$refs.file.value = null; $refs.file.dispatchEvent(new Event('change'));" class="w-min hover:dark:bg-white hover:bg-black pointer-events-auto rounded-full p-1 group transition-colors duration-200">
                                    <svg class="w-6 h-6 dark:text-white text-black group-hover:dark:text-black group-hover:text-white transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input wire:model="message" class="w-full p-2 dark:text-white text-black bg-transparent pr-12 outline-none" placeholder="Type here...">
                        <input x-ref="file" type="file" x-on:upload-file.window="uploadFile()" x-on:reset-file.window="$refs.file.value = null; $refs.file.dispatchEvent(new Event('change'));" @change="handleFileSelect" class="hidden">
                        <input wire:model="file" class="bg-black hidden">
                        <div class="absolute top-0 bottom-0 right-2 flex items-center">
                            <div @click="$refs.file.click()" class="hover:dark:bg-white hover:bg-black rounded-full group duration-200">
                                <svg class="w-8 h-8 dark:text-white text-black group-hover:dark:text-black group-hover:text-white  duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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