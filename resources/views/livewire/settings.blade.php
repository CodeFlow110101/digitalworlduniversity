<?php

use App\Models\LkUserPlan;
use App\Models\Wallet;
use Carbon\Carbon;

use function Livewire\Volt\{mount, state};

state(['user', 'balance', 'days_remaining', 'expiry_date',]);

mount(function ($user) {
    $this->$user = $user;
    $this->balance = Wallet::where('user_id', $this->user->id)->first()->amount;
    $this->expiry_date = LkUserPlan::where('user_id', $this->user->id)->first()->expiry_date;
    $this->days_remaining = (int)Carbon::now()->diffInDays($this->expiry_date);
});

?>

<div>
    <div class="fixed z-10 bottom-12 right-12 flex justify-between gap-4">
        <button wire:click="$dispatch('show-modal', { modal:'modal-update-user', args:null, data:null, callback_event:null })" class="hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
            <div>
                <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="text-[#131e30] font-semibold">
                Update Details
            </div>
        </button>
        <button wire:click="$dispatch('show-modal', { modal:'modal-reset-password', args:null, data:null, callback_event:null })" class="hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
            <div>
                <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="text-[#131e30] font-semibold">
                Update Password
            </div>
        </button>
    </div>

    <div class="text-[#131e30] grid grid-cols-1 gap-8 sm:gap-20 text-xl lg:text-3xl">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-20 text-center font-bold text-xl lg:text-2xl">
            <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">Student ID: {{$user->id}}</div>
            <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">{{$days_remaining}} Days</div>
            <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">Wallet: ${{$balance}}</div>
        </div>
        <div class="bg-[#d6dcde] rounded-2xl py-12 px-2 text-center font-bold">Name: {{$user->name}}</div>
        <div class="bg-[#d6dcde] rounded-2xl py-12 px-2 text-center font-bold select-text">Email: {{$user->email}}</div>
    </div>
</div>