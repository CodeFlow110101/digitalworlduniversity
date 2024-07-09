<?php

use function Livewire\Volt\{state};

//

?>

<div class="w-3/5 bg-black p-10">
    <div class="grid grid-cols-1 gap-2">
        <div class="text-white text-3xl font-bold uppercase">Join Digital Worlds University</div>
        <div class="text-white text-2xl font-normal uppercase">Escape the Matrix</div>
    </div>

    <div class="mt-12">
        <div class="flex justify-between items-center whitespace-nowrap gap-2 w-min">
            <div class="p-1 rounded-full bg-gray-400 flex justitfy-center items-center">
                <svg class="w-5 h-5 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 11.917 9.724 16.5 19 7.5" />
                </svg>
            </div>
            <div class="text-gray-400 uppercase text-xl font-bold">Personal Information</div>
        </div>
        <div class="px-8 grid grid-cols-1 gap-3 mt-4">
            <div class="text-gray-400">Email Address</div>
            <div><input type="email" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="example@gmail.com"></div>
            <div class="text-gray-400">First Name</div>
            <div><input type="email" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="First Name"></div>
            <div class="text-gray-400">Last Name</div>
            <div><input type="email" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="Last Name"></div>
        </div>
    </div>

    <div class="mt-12">
        <div class="flex justify-between items-center whitespace-nowrap gap-2 w-min">
            <div class="p-1 rounded-full bg-gray-400 flex justitfy-center items-center">
                <svg class="w-5 h-5 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 11.917 9.724 16.5 19 7.5" />
                </svg>
            </div>
            <div class="text-gray-400 uppercase text-xl font-bold">Select plan</div>
        </div>

        <div class="flex justify-between gap-8 mt-6">
            <div class="w-full bg-gray-700 grid-cols-1 px-5 py-4 gap-4 rounded-lg">
                <div class="font-bold text-white text-2xl">$49.99<span class="text-xl text-gray-300 font-normal">/
                        monthly</span>
                </div>
                <div class="text-2xl text-left text-white">Cadet</div>
                <div class="text-sm text-left text-white">A first step towards breaking free</div>
                <div class="w-full mt-48 text-white text-2xl text-center font-bold py-2 rounded-lg bg-[#f6aa23]">Select
                </div>
            </div>
            <div class="w-full bg-gray-700 grid-cols-1 px-5 py-4 gap-4 rounded-lg">
                <div class="font-bold text-white text-2xl">$49.99<span class="text-xl text-gray-300 font-normal">/
                        monthly</span>
                </div>
                <div class="text-2xl text-left text-white">Cadet</div>
                <div class="text-sm text-left text-white">A first step towards breaking free</div>
                <div class="w-full mt-48 text-white text-2xl text-center font-bold py-2 rounded-lg bg-[#f6aa23]">Select
                </div>
            </div>
            <div class="w-full bg-gray-700 grid-cols-1 px-5 py-4 gap-4 rounded-lg">
                <div class="font-bold text-white text-2xl">$49.99<span class="text-xl text-gray-300 font-normal">/
                        monthly</span>
                </div>
                <div class="text-2xl text-left text-white">Cadet</div>
                <div class="text-sm text-left text-white">A first step towards breaking free</div>
                <div class="w-full mt-48 text-white text-2xl text-center font-bold py-2 rounded-lg bg-[#f6aa23]">Select
                </div>
            </div>
        </div>
    </div>
</div>
