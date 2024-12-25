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
    <div class="h-full flex flex-col gap-2 justify-around">
        <div>
            <div class="flex justify-center">
                <img class="size-10 lg:size-16 rounded-full" src="{{ asset('images/logo.jpeg') }}" alt="Example Image">
            </div>
            <div class="flex justify-center text-black dark:text-white xl:font-semibold xl:text-xl max-lg:hidden">
                <div class="artemisia">D<span class="didot">igital</span> W<span class="didot">orld</span> U<span class="didot">niversity</span></div>
            </div>
        </div>

        <div class="my-auto border border-black/30 dark:border-white/30 rounded-full h-0 lg:mx-4 mx-4 xl:mx-8"></div>

        <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
            <div class="overflow-y-auto inset-x-0 absolute" :style="'height: ' + height + 'px;'">
                <div class="grid grid-cols-1 gap-3 py-4">
                    <div>
                        <a href="/dashboard" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'dashboard') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                            <svg class="size-6 transition-colors duration-300 @if($path == 'dashboard') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z" />
                            </svg>
                            <div class="max-lg:hidden">Dashboard</div>
                        </a>
                    </div>
                    @if(Gate::allows('is_Admin'))
                    <a href="/admin-panel" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if(str_contains($path, 'admin-panel')) bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'admin-panel') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        </svg>
                        <div class="max-lg:hidden">Admin Panel</div>
                    </a>
                    @endif
                    @if(Gate::check('is_subscription_Active'))
                    <a href="/programs" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'programs' || $path == 'videos' || $path == 'video-player') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'programs') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                        </svg>
                        <div class="max-lg:hidden">Programs</div>
                    </a>
                    <a href="/live-chat" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'live-chat') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'live-chat') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                        </svg>
                        <div class="max-lg:hidden">Support Live Chat</div>
                    </a>
                    <a href="/earn-money" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'earn-money') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'earn-money') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="1.3" d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                        <div class="max-lg:hidden">Earn Money Survey</div>
                    </a>
                    <a href="/find-jobs" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'find-jobs') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'find-jobs') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                        </svg>
                        <div class="max-lg:hidden">Apply for Jobs</div>
                    </a>
                    <a href="/ai-tutor" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'ai-tutor') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'ai-tutor') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 18.5A2.493 2.493 0 0 1 7.51 20H7.5a2.468 2.468 0 0 1-2.4-3.154 2.98 2.98 0 0 1-.85-5.274 2.468 2.468 0 0 1 .92-3.182 2.477 2.477 0 0 1 1.876-3.344 2.5 2.5 0 0 1 3.41-1.856A2.5 2.5 0 0 1 12 5.5m0 13v-13m0 13a2.493 2.493 0 0 0 4.49 1.5h.01a2.468 2.468 0 0 0 2.403-3.154 2.98 2.98 0 0 0 .847-5.274 2.468 2.468 0 0 0-.921-3.182 2.477 2.477 0 0 0-1.875-3.344A2.5 2.5 0 0 0 14.5 3 2.5 2.5 0 0 0 12 5.5m-8 5a2.5 2.5 0 0 1 3.48-2.3m-.28 8.551a3 3 0 0 1-2.953-5.185M20 10.5a2.5 2.5 0 0 0-3.481-2.3m.28 8.551a3 3 0 0 0 2.954-5.185" />
                        </svg>
                        <div class="max-lg:hidden">AI Tutor</div>
                    </a>
                    <a href="/exam" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'exam') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'exam') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-5-4v4h4V3h-4Z" />
                        </svg>
                        <div class="max-lg:hidden">Exam</div>
                    </a>
                    <a href="/store" wire:navigate class="flex justify-center lg:justify-start items-center gap-2 lg:mx-4 mx-2 xl:mx-8 text-center xl:text-left py-2 lg:px-2 xl:px-4 group @if($path == 'store') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-base xl:text-md cursor-pointer tracking-wider transition-all duration-300 rounded-lg font-noramal hover:-translate-x-1 hover:-translate-y-1 hover:shadow-lg hover:dark:shadow-white hover:shadow-black">
                        <svg class="size-6 transition-colors duration-300 @if($path == 'store') dark:text-black text-white @else dark:text-white text-black group-hover:dark:text-black group-hover:text-white @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                        </svg>
                        <div class="max-lg:hidden">Store</div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-auto flex justify-center max-lg:hidden">
            <div class="w-full grid grid-cols-1 gap-1">
                <div class="flex justify-center">
                    @if($user->image)
                    <img wire:click="redirectTo('settings')" src="{{asset('storage/'.$user->image)}}" class="size-10 rounded-full cursor-pointer">
                    @else
                    <svg wire:click="redirectTo('settings')" class="size-10 text-black dark:text-white cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                            clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                <div class="text-center text-md font-bold text-black dark:text-white">{{$user->name}}</div>
                <div class="text-center text-[##a2acb4] font-thin text-black dark:text-white">Student Id:{{$user->id}}</div>
            </div>
        </div>
        <div x-data="darkMode" class="flex justify-end mx-auto">
            <label class="inline-flex items-center cursor-pointer">
                <input x-model="value" @change="toggle" type="checkbox" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200  peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 max-lg:hidden">Dark Mode</span>
            </label>
        </div>
        <div class="flex max-lg:flex-col justify-evenly gap-2">
            <div class="max-lg:grow w-full">
                <a href="/withdraw" wire:navigate
                    class="w-full flex justify-center py-1 px-2 xl:px-2 @if($path == '') lg:bg-black text-white dark:text-black lg:dark:bg-white @else dark:text-white lg:hover:dark:bg-white dark:hover:text-black lg:hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-sm xl:text-base cursor-pointer tracking-wider transition-opacity duration-300 rounded-md font-noramal transition-colors duration-500">
                    <div class="max-lg:hidden">Withdraw</div>
                    <div class="lg:hidden flex justify-center">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="flex justify-center w-full max-lg:grow w-full">
                <div wire:click="logOut"
                    class="w-full flex justify-center py-1 px-2 xl:px-2 @if($path == '') bg-black text-white dark:text-black dark:bg-white @else dark:text-white hover:dark:bg-white dark:hover:text-black hover:bg-black hover:text-white bg-transparent text-black  @endif lg:text-sm xl:text-base cursor-pointer tracking-wider transition-opacity duration-300 rounded-md font-noramal transition-colors duration-500">
                    <div class="max-lg:hidden">Sign Out</div>
                    <div class="lg:hidden flex justify-center">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>