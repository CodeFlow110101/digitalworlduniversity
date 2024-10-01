<?php

use App\Models\Transaction;

use function Livewire\Volt\{state, mount};

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

mount(function ($transaction) {
    unset($transaction['opt_a']);
    unset($transaction['opt_b']);
    unset($transaction['opt_c']);
    unset($transaction['opt_d']);
    Transaction::create($transaction);
});
?>

<div class="bg-black h-dvh w-full flex justify-center items-center">
    <div class="h-min relative grid grid-cols-1 gap-2 text-[#f6aa23] border-4 border-[#f6aa23] rounded-xl p-6 pt-10">
        <div class="absolute -top-8 w-full flex justify-center">
            <div class="rounded-full p-4 bg-red-500  w-min">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold py-4">Payment Failed</div>
        <div wire:click="redirectTo('sign-up')"
            class="sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-[#f6aa23] hover:text-white hover:bg-[#f6aa23] transition-opacity duration-300 rounded-lg text-[#f6aa23] font-bold transition-colors duration-500">
            Back
        </div>
    </div>
</div>