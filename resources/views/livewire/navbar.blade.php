<?php

use function Livewire\Volt\{state};

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

?>

<div class="flex justify-center py-8">
    <div x-data="{ showDropdown: false }" class="w-4/5 flex justify-between relative">
        <div class="text-white font-bold text-xl">Digital Worlds University</div>
        <div class="flex justify-between gap-5">
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Features</div>
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Interviews</div>
            <div class="text-white hover:text-[#f6aa23] cursor-pointer text-lg">Explorer</div>
            <div @mouseenter="showDropdown = true" @mouseleave="showDropdown = false" class="text-white cursor-pointer">
                <div class="flex justify-between items-center gap-2">
                    <div class="text-lg">Courses</div>
                    <div>
                        <svg :class="showDropdown ? 'rotate-180' : 'rotate - 0'"
                            class="w-3 h-3 transition-transform duration-300 text-gray-800 dark:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="flex justify-between gap-2">
                <div wire:click="redirectTo('log-in')"
                    class="py-1.5 px-4 cursor-pointer tracking-wider border border-[#f6aa23] rounded-lg text-[#f6aa23] hover:text-[#050e14] transition-colors duration-500 hover:bg-[#f6aa23]">
                    Log
                    in</div>
                <div wire:click="redirectTo('sign-up')"
                    class="py-1.5 px-4 cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-[#050e14] transition-colors duration-500 bg-[#f6aa23]">
                    Join
                    Now</div>
            </div>
        </div>
        <div x-cloak :class="showDropdown ? 'opacity-100' : 'opacity-0 pointer-events-none'"
            class="absolute transition-opacity duration-500 top-6 w-full flex justify-center">
            <div @mouseenter="showDropdown = true" @mouseleave="showDropdown = false"
                class="p-1 pt-12 w-1/2 flex justify-center text-white rounded-lg bg-[#050e14]">
                <div class="flex justify-between w-full gap-2">
                    <div class="w-full grid grid-cols-1 gap-4">
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">
                            Copywriting
                        </div>
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">
                            Freelanding
                        </div>
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">
                            E-Commercs
                        </div>
                    </div>
                    <div class="w-full grid grid-cols-1 gap-4">
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">Stocks
                        </div>
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">Business
                            &
                            Finance
                        </div>
                        <div class="hover:bg-white/10 transition-colors duration-500 rounded-lg py-3 px-4">User
                            Generated
                            Content</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
