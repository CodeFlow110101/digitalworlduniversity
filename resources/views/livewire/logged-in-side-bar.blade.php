<?php

use function Livewire\Volt\{state};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$logOut = function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $this->redirectRoute('landing-page', navigate: true);
};
//
?>

<div class="bg-gray-900 h-full py-16 ">
    <div class="grid grid-cols-1 gap-24">
        <div class="flex justify-center">
            <svg class="w-24 h-24 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Dashboard</div>
            </div>
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Programs</div>
            </div>
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Live Chat</div>
            </div>
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Find Jobs</div>
            </div>
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Store</div>
            </div>
            <div>
                <div
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Earn Money</div>
            </div>
            <div>
                <div wire:click="logOut"
                    class="mx-8 py-2 text-center text-lg cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-gray-900 font-bold transition-colors duration-500 bg-[#f6aa23]">
                    Sign Out</div>
            </div>
        </div>
    </div>
</div>
