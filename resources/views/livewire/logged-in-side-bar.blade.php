<?php

use function Livewire\Volt\{state, mount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

state(['path']);
state(['user'])->reactive();

$logOut = function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $this->redirectRoute('landing-page', navigate: true);
};

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

mount(function ($path, $user) {
    $this->path = $path;
    $this->user = $user;
});

?>

<div class="h-full flex flex-col py-6 dark:bg-black bg-white rounded-2xl select-none">
    <div class="h-full flex flex-col justify-around">
        <div>
            <div class="flex justify-center">
                <img class="w-16 h-16 rounded-full" src="{{ asset('images/logo.jpeg') }}" alt="Example Image">
            </div>
            <div class="flex justify-center text-black dark:text-white xl:font-semibold xl:text-xl">
                <div class="artemisia">D<span class="didot">igital</span> W<span class="didot">orld</span> U<span class="didot">niversity</span></div>
            </div>
        </div>

        <div class="my-auto border border-[#b5c1c9] rounded-full h-0 lg:mx-4 mx-4 xl:mx-8"></div>

        <div class="my-auto overflow-y-auto max-h-[40vh]">
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <a href="/dashboard" wire:navigate class="flex justify-start items-center gap-2 lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'dashboard') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                        Dashboard
                    </a>
                </div>
                @if(Gate::allows('is_Admin'))
                <a href="/admin-panel" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if(str_contains($path, 'admin-panel')) bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Admin Panel
                </a>
                @endif
                @if(Gate::check('is_subscription_Active'))
                <a href="/programs" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'programs' || $path == 'videos' || $path == 'video-player') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Programs
                </a>
                <a href="/live-chat" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'live-chat') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Support Live Chat
                </a>
                <a href="/earn-money" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'earn-money') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Earn Money Survey
                </a>
                <a href="/find-jobs" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'find-jobs') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Apply for Jobs
                </a>
                <a href="/ai-tutor" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'ai-tutor') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    AI Tutor
                </a>
                <a href="/exam" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'exam') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Exam
                </a>
                <a href="/store" wire:navigate class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'store') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-opacity duration-300 rounded-lg font-noramal transition-colors duration-500">
                    Store
                </a>
                @endif
            </div>
        </div>
        <div class="mt-auto flex justify-center">
            <div class="w-full grid grid-cols-1 gap-1">
                <div class="flex justify-center">
                    @if($user->image)
                    <img wire:click="redirectTo('settings')" src="{{asset('storage/'.$user->image)}}" class="w-14 h-14 rounded-full cursor-pointer">
                    @else
                    <svg wire:click="redirectTo('settings')" class="w-14 h-14 text-black dark:text-white cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                            clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                <div class="text-center text-md font-bold text-black dark:text-white">{{$user->name}}</div>
                <div class="text-center text-[##a2acb4] text-lg font-thin text-black dark:text-white">{{$user->email}}</div>
            </div>
        </div>
        <div class="flex justify-around gap-2">
            <div>
                <div
                    class="w-full text-center py-1 px-2 xl:px-2 @if($path == '') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-sm xl:text-base cursor-pointer tracking-wider transition-opacity duration-300 rounded-md font-noramal transition-colors duration-500">
                    Withdraw</div>
            </div>
            <div>
                <div wire:click="logOut"
                    class="w-full text-center py-1 px-2 xl:px-2 @if($path == '') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-sm xl:text-base cursor-pointer tracking-wider transition-opacity duration-300 rounded-md font-noramal transition-colors duration-500">
                    Sign Out</div>
            </div>
        </div>
    </div>
</div>