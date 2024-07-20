<?php

use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, on, placeholder, usesPagination};

usesPagination();

state(['channels', 'current_channel', 'user_id', 'message']);

placeholder('<div class="w-full h-96 mt-10 flex justify-center items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-white animate-spin fill-[#131e30]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>');

with(function () {
    $this->dispatch('scroll-bottom');
    return ['chats' => Chat::where('channel_id', $this->current_channel->id)->orderBy('created_at', 'desc')->limit(200)->paginate(200)->reverse()];
});

$setChannel = function ($id) {
    $this->current_channel = Channel::find($id);
};

on(['live-chat-handle-message' => function ($validationKey, $validationMessage, $fileName, $filePath) {
    $this->resetValidation();

    if ($validationKey && $validationMessage) {
        $this->addError('file', $validationMessage['file']);
        $this->dispatch('live-chat-loader', value: false);
        return;
    }

    if (($this->message && rtrim($this->message) != "") || ($fileName && $filePath)) {
        Chat::create(
            [
                'user_id' => $this->user_id,
                'message' => $this->message,
                'channel_id' => $this->current_channel->id,
                'file_name' => $fileName,
                'file_path' => $filePath,
            ]
        );
        $this->reset(['message']);
        $this->dispatch('clear-file');
    }

    $this->dispatch('live-chat-loader', value: false);
}]);

$downloadFile = function ($id) {
    $chat = Chat::find($id);
    return Storage::disk('public')->download($chat->file_path, $chat->file_name);
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
                <div x-init="$refs.chatSection.scrollTop = $refs.chatSection.scrollHeight" x-on:scroll-bottom.window="$refs.chatSection.scrollTop = $refs.chatSection.scrollHeight;" x-ref="chatSection" class="rounded-2xl px-4 overflow-auto max-h-96 lg:max-h-[480px] grid grid-cols-1 gap-4 sm:gap-6">
                    @foreach($chats as $chat)
                    <div wire:key="chat{{ $chat->id }}" class="w-full @if($user_id == $chat->user_id) flex justify-end @else justify-start @endif">
                        @if($chat->file_name && $chat->file_path)
                        <div class="py-1 sm:py-2 px-2 sm:px-6 rounded-xl sm:rounded-2xl text-wrap w-4/5 bg-[#b5c1c9] grid grid-cols-1 gap-2">
                            <div>
                                <svg wire:click="downloadFile({{$chat->id}})" class="w-12 h-12 text-[#131e30] cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-sm">{{$chat->file_name}}</div>
                        </div>
                        @else
                        <div class="py-1 sm:py-2 px-2 sm:px-6 rounded-xl sm:rounded-2xl text-wrap w-4/5 bg-[#b5c1c9]">
                            <div class="font-text-sx sm:font-normal  @if($user_id == $chat->user_id) text-left @else text-right @endif"> {{$chat->message}}</div>
                            <div class="text-xs max-sm:hidden @if($user_id == $chat->user_id) text-right @else text-left @endif">{{$chat->created_at}}</div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div x-data="{isFileAttached:false}" class="w-full px-4 pb-4">
            <!-- <input x-ref="message" class="px-6 py-2 sm:py-4 w-full rounded-t-2xl bg-[#b5c1c9] outline-none font-semibold" placeholder="Message"> -->
            <input wire:model="message" class="px-6 py-2 sm:py-4 w-full rounded-t-2xl bg-[#b5c1c9] outline-none font-semibold" placeholder="Message">
            <div class="flex justify-between bg-[#b5c1c9] rounded-b-2xl p-2 sm:p-4">
                <div class="w-min flex justify-between items-center gap-4 relative">
                    <div @click="$refs.file.click()" class="hover:bg-gray-300 cursor-pointer p-1 rounded-full bg-transparent">
                        <svg class="w-6 h-6 rotate-45 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" />
                        </svg>
                        <div x-cloak x-show="isFileAttached" class="top-0 left-6 absolute w-4 h-4 bg-green-400 border-2 border-black text-white rounded-full"></div>
                    </div>
                    <div x-cloak x-show="isFileAttached" x-ref="fileClearButton" x-on:clear-file.window="$refs.fileClearButton.click()" @click="$refs.file.value = null; isFileAttached = false" class="cursor-pointer p-1 rounded-full bg-red-600">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                    </div>
                    @error('file')<div class="text-red-600 whitespace-nowrap">{{$message}}</div>@enderror
                </div>
                <div x-data="{showLoader:false}" x-on:live-chat-loader.window="showLoader = event.detail.value" :class="showLoader && 'pointer-events-none'" wire:click="$dispatch('send-message', { file: $refs.file, fileSizeLimit:4, callbackDispatch:'live-chat-handle-message', callbackLoaderDispatch:'live-chat-loader'})" class="cursor-pointer py-1 text-md text-center px-4 w-min text-white rounded-lg bg-[#131e30]">
                    <div x-show="!showLoader">Send</div>
                    <div x-show="showLoader" class="flex justify-center mx-1">
                        <svg aria-hidden="true" class="w-6 h-6 text-[#131e30] animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                        </svg>
                    </div>
                </div>
                <input @change="isFileAttached=$refs.file.value ? true : false" type="file" x-ref="file" class="hidden">
            </div>
        </div>
    </div>
</div>