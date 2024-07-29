<?php

use App\Models\Program;

use function Livewire\Volt\{state, with};

with(fn() => ['programs' => Program::get()]);

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

?>

<div class="flex justify-center py-8">
    <div x-data="{ showDropdown: false ,showMobileHeader: false}" class="lg:w-4/5 w-11/12 flex justify-between items-center max-sm:gap-2 relative">
        <div class="text-white font-bold sm:text-xl text-base flex justify-between items-center gap-4">
            <div>Digital Worlds University</div>
            <div>
                <img class="w-10 h-10 sm:w-14 sm:h-14 rounded-full" src="{{ asset('images/logo.jpg') }}" alt="Example Image">
            </div>
        </div>
        <div class="flex justify-between gap-5 max-lg:hidden">
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Features</div>
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Interviews</div>
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Explorer</div>
            <div @mouseenter="showDropdown = true" @mouseleave="showDropdown = false" class="text-white cursor-pointer">
                <div class="flex justify-between items-center gap-2">
                    <div class="text-lg">Courses</div>
                    <div>
                        <svg :class="showDropdown ? 'rotate-180' : 'rotate - 0'"
                            class="w-3 h-3 transition-transform duration-300 text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-lg:hidden">
            <div class="flex justify-between items-center gap-2 max-sm:text-sm">
                <div wire:click="redirectTo('log-in')"
                    class="py-1.5 sm:px-4 px-2 whitespace-nowrap cursor-pointer tracking-wider border border-[#f6aa23] rounded-lg text-[#f6aa23] hover:text-[#050e14] transition-colors duration-500 hover:bg-[#f6aa23]">
                    @if(Auth::check())
                    Dashboard
                    @else
                    Log
                    in
                    @endif
                </div>
                @if(!Auth::check())
                <div wire:click="redirectTo('sign-up')"
                    class="py-1.5 sm:px-4 px-2 whitespace-nowrap cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-[#050e14] transition-colors duration-500 bg-[#f6aa23]">
                    Join
                    Now</div>
                @endif
            </div>
        </div>
        <div class="lg:hidden">
            <div @click="showMobileHeader=!showMobileHeader" class="w-min border border-[#f6aa23] text-[#f6aa23] p-1 lg:hidden rounded-lg">
                <svg x-show="!showMobileHeader" class="sm:w-8 sm:h-8 w-5 h-5 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
                <svg x-show="showMobileHeader" class="sm:w-8 sm:h-8 w-5 h-5 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>
        </div>

        <div x-cloak :class="showMobileHeader ? 'scale-y-100' : 'scale-y-0 pointer-events-none'" class="transition-transform origin-top absolute top-16 bg-[#050e14] w-full py-3 px-2 lg:hidden">
            <div class="grid grid-cols-1 w-full gap-3">
                <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Features</div>
                <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Interviews</div>
                <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Explorer</div>
                <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Courses</div>
                @foreach($programs as $program)
                <div class="text-gray-400 hover:text-[#f6aa23] cursor-pointer text-lg">
                    {{$program->title}}
                </div>
                @endforeach
                <div wire:click="redirectTo('log-in')"
                    class="py-1.5 sm:px-4 px-2 whitespace-nowrap cursor-pointer tracking-wider border border-[#f6aa23] rounded-lg text-[#f6aa23] hover:text-[#050e14] transition-colors duration-500 hover:bg-[#f6aa23]">
                    @if(Auth::check())
                    Dashboard
                    @else
                    Log
                    in
                    @endif
                </div>
                @if(!Auth::check())
                <div wire:click="redirectTo('sign-up')"
                    class="py-1.5 sm:px-4 px-2 whitespace-nowrap cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-[#050e14] transition-colors duration-500 bg-[#f6aa23]">
                    Join
                    Now</div>
                @endif
            </div>
        </div>

        <div x-cloak :class="showDropdown ? 'opacity-100' : 'opacity-0 pointer-events-none'"
            class="absolute transition-opacity duration-500 top-6 w-full flex justify-center">
            <div @mouseenter="showDropdown = true" @mouseleave="showDropdown = false"
                class="p-1 pt-12 w-1/2 flex justify-center text-white rounded-lg bg-[#050e14]">
                <div class="grid grid-cols-2 w-full gap-2">
                    @foreach($programs as $program)
                    <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">
                        {{$program->title}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>