<?php

use function Livewire\Volt\{state, layout, mount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

layout('components.layouts.app');

state(['path']);

mount(function (Request $request) {
    $this->path = $request->path();

    if (($this->path == 'log-in' || $this->path == 'sign-up') && Auth::check()) {
        $this->redirectRoute('dashboard', navigate: true);
    }
});

?>

<div x-data="{showSidebar:false}" class="lg:flex lg:justify-between relative bg-black">
    <div class="w-3/12 p-6 max-lg:hidden"><livewire:logged-in-side-bar :path="$path"></div>
    <div :class="showSidebar ? 'translate-x-0' : '-translate-x-64'" class="w-64 p-6 transition-transform duration-200 absolute lg:hidden"><livewire:logged-in-side-bar :path="$path"></div>
    <div class="lg:w-9/12 w-full p-6 grid grid-cols-1 gap-8 h-min">
        <div class="flex justify-center">
            <div class="py-8 px-8 items-center w-full flex justify-between rounded-2xl bg-gray-900 text-3xl text-center text-[#f6aa23] font-bold">
                <div class="w-min lg:hidden"></div>
                <div class="w-full">Dashboard</div>
                <div @click="showSidebar = !showSidebar" class="w-min border border-[#f6aa23] p-1 lg:hidden rounded-lg">
                    <svg x-show="!showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                    <svg x-show="showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </div>
            </div>

        </div>
        <div class="bg-gray-900 rounded-2xl p-8">
            @if($path == 'dashboard')
            <livewire:dashboard>
                @endif
        </div>
    </div>
</div>