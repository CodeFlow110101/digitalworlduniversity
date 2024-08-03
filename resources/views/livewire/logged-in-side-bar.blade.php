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

<div class="bg-[#d6dcde] dark:bg-gray-800 h-min py-16 rounded-2xl select-none">
    <div class="grid grid-cols-1 gap-8">
        <div class="flex justify-center">
            <img class="w-16 h-16 rounded-full" src="{{ asset('images/logo.jpg') }}" alt="Example Image">
        </div>
        <div class="flex justify-center text-[#131e30] dark:text-[#DDE6ED] xl:font-semibold xl:text-2xl">
            Digital Worlds University
        </div>
        <div class="border border-[#b5c1c9] rounded-full h-0 lg:mx-4 mx-4 xl:mx-8"></div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <div wire:click="redirectTo('dashboard')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'dashboard') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Dashboard
                </div>
            </div>
            @if(Gate::allows('is_Admin'))
            <div>
                <div wire:click="redirectTo('admin-panel')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if(str_contains($path, 'admin-panel')) bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Admin Panel</div>
            </div>
            @endif
            <div>
                <div wire:click="redirectTo('programs')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'programs' || $path == 'videos' || $path == 'video-player') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Programs</div>
            </div>
            <div>
                <div wire:click="redirectTo('live-chat')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'live-chat') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Live Chat</div>
            </div>
            <div>
                <div wire:click="redirectTo('find-jobs')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'find-jobs') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Find Jobs</div>
            </div>
            <div>
                <div wire:click="redirectTo('store')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'store') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Store</div>
            </div>
            <div>
                <div wire:click="redirectTo('earn-money')"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 @if($path == 'earn-money') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-full font-noramal transition-colors duration-500">
                    Earn Money</div>
            </div>
        </div>
        <div class="flex justify-center">
            <div class="w-full grid grid-cols-1 gap-1">
                <div class="flex justify-center">
                    @if($user->image)
                    <img wire:click="redirectTo('settings')" src="{{asset('storage/'.$user->image)}}" class="w-14 h-14 rounded-full cursor-pointer">
                    @else
                    <svg wire:click="redirectTo('settings')" class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED] cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                            clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                <div class="text-center text-xl font-bold text-[#131e30] dark:text-[#DDE6ED]">{{$user->name}}</div>
                <div class="text-center text-[##a2acb4] text-lg font-thin text-[#131e30] dark:text-[#DDE6ED]">{{$user->email}}</div>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <div
                    class="lg:mx-4 mx-4 xl:mx-8 text-center py-2 px-2 xl:px-4 @if($path == '') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-xl font-noramal transition-colors duration-500">
                    Billing</div>
            </div>
            <div>
                <div wire:click="logOut"
                    class="lg:mx-4 mx-4 xl:mx-8 text-center py-2 px-2 xl:px-4 @if($path == '') bg-[#131e30] text-[#fafbfb] dark:text-[#27374D] dark:bg-[#DDE6ED] @else dark:text-[#fafbfb] hover:dark:bg-[#DDE6ED] dark:hover:text-[#27374D] hover:bg-[#131e30] hover:text-[#fafbfb] bg-transparent text-[#131e30]  @endif lg:text-md xl:text-lg cursor-pointer tracking-wider transition-opacity duration-300 rounded-xl font-noramal transition-colors duration-500">
                    Sign Out</div>
            </div>
        </div>
    </div>
</div>