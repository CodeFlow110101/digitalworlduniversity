<?php

use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, mount, with, on, placeholder, usesPagination};

usesPagination();

state(['channels', 'current_channel', 'user_id', 'message']);



with(function () {
    $this->dispatch('scroll-bottom');
    return ['chats' => Chat::select(['chats.*', 'users.name'])->where('channel_id', $this->current_channel->id)->join('users', 'users.id', 'chats.user_id')->orderBy('created_at', 'desc')->limit(200)->paginate(200)->reverse()];
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
    <div class=" h-full w-full grid grid-cols-1 gap-4">
        <div class="rounded-2xl pt-4 p-4 h-full w-full flex justify-between gap-2 sm:gap-4">
            <div class="bg-[#d6dcde] rounded-2xl h-full grid grid-cols-1 gap-2">
                <div class="bg-[#b5c1c9] rounded-2xl w-min pr-4 overflow-auto no-scrollbar h-full flex justify-center">
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
            <div class="w-full select-none">
                <div class=" text-center py-4 sm:py-8 font-thin text-4xl select-none">{{$this->current_channel->name}}</div>
                <div x-init="$refs.chatSection.scrollTop = $refs.chatSection.scrollHeight" x-on:scroll-bottom.window="$refs.chatSection.scrollTop = $refs.chatSection.scrollHeight;" x-ref="chatSection" class="rounded-2xl px-4 overflow-auto max-h-96 lg:max-h-[480px] grid grid-cols-1 gap-12 sm:gap-6">
                    @foreach($chats as $chat)
                    <div wire:key="chat{{ $chat->id }}" class="w-full @if($user_id == $chat->user_id) flex justify-end @else justify-start @endif">
                        @if($chat->file_name && $chat->file_path)
                        <div class="flex justify-between gap-2">
                            @if($user_id != $chat->user_id)
                            <div class="w-min">
                                <svg class="w-5 h-5 lg:w-10 lg:h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                            <div class="grid grid-cols-1 gap-2">
                                @if($user_id != $chat->user_id)
                                <div class="flex justify-between items-center gap-2">
                                    <div class="font-bold text-sm lg:text-lg">{{$chat->name}}</div>
                                    <div class="text-xs w-full text-left break-words text-wrap">{{$chat->created_at}}</div>
                                </div>
                                <div class="rounded-xl sm:rounded-2xl text-wrap w-full @if($user_id == $chat->user_id) text-right @else text-left @endif">
                                    <div class="text-sx sm:font-normal tracking-tighter break-words text-wrap"> {{$chat->message}}</div>
                                </div>
                                @else
                                <div class="flex justify-between items-center gap-2">
                                    <div class="text-xs w-full text-right break-words text-wrap">{{$chat->created_at}}</div>
                                    <div class="font-bold text-sm lg:text-lg">{{$chat->name}}</div>
                                </div>
                                <div class="rounded-xl sm:rounded-2xl text-wrap w-full @if($user_id == $chat->user_id) text-right @else text-left @endif">
                                    <div class="text-sx sm:text-base sm:font-normal tracking-tighter break-words text-wrap"> {{$chat->message}}</div>
                                </div>
                                @endif
                                <div class="py-4 sm:py-6 px-6 sm:px-6 rounded-xl sm:rounded-2xl text-wrap w-full bg-[#b5c1c9] grid grid-cols-1 gap-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <svg class="w-8 h-8 sm:w-8 sm:h-8 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <svg wire:click="downloadFile({{$chat->id}})" class="w-6 h-6 sm:w-8 sm:h-8 text-[#131e30] cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-sm">{{$chat->file_name}}</div>
                                </div>
                            </div>
                            @if($user_id == $chat->user_id)
                            <div class="w-min">
                                <svg class="w-5 h-5 lg:w-10 lg:h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="flex justify-between items-center gap-2 w-full">
                            @if($user_id != $chat->user_id)
                            <div class="w-min">
                                <svg class="w-5 h-5 lg:w-10 lg:h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                            <div class="w-full">
                                @if($user_id != $chat->user_id)
                                <div class="flex justify-between items-center gap-2">
                                    <div class="font-bold text-sm lg:text-lg">{{$chat->name}}</div>
                                    <div class="text-xs w-full text-left break-words text-wrap">{{$chat->created_at}}</div>
                                </div>
                                <div class="rounded-xl sm:rounded-2xl text-wrap w-full @if($user_id == $chat->user_id) text-right @else text-left @endif">
                                    <div class="text-xs sm:text-base sm:font-normal tracking-tighter break-words text-wrap"> {{$chat->message}}</div>
                                </div>
                                @else
                                <div class="flex justify-between items-center gap-2">
                                    <div class="text-xs w-full text-right break-words text-wrap">{{$chat->created_at}}</div>
                                    <div class="font-bold text-sm lg:text-lg">{{$chat->name}}</div>
                                </div>
                                <div class="rounded-xl sm:rounded-2xl text-wrap w-full @if($user_id == $chat->user_id) text-right @else text-left @endif">
                                    <div class="text-xs sm:text-base sm:font-normal tracking-tighter break-words text-wrap"> {{$chat->message}}</div>
                                </div>
                                @endif

                            </div>
                            @if($user_id == $chat->user_id)
                            <div class="w-min">
                                <svg class="w-5 h-5 lg:w-10 lg:h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div x-data="{isFileAttached:false}" class="w-full px-4 pb-4">
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