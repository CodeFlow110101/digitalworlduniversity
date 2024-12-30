<?php

use function Livewire\Volt\{state, mount, placeholder};

use App\Models\LkUserPlan;
use App\Models\ReferralCode;
use App\Models\ReferralIncome;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


state(['id', 'user', 'days_remaining', 'expiry_date', 'referral_code', 'url']);



mount(function ($url) {
    $this->user = Auth::user();
    $this->id = $this->user->id;
    $this->url = $url;
    $this->expiry_date = LkUserPlan::where('user_id', $this->id)->first()->expiry_date;
    $this->days_remaining = (int)Carbon::now()->diffInDays($this->expiry_date) <= 0 ? 'Subscription Expired' : ((int)Carbon::now()->diffInDays($this->expiry_date) . " Days Till Expiry");
    $this->referral_code = ReferralCode::where('user_id', $this->id)->first()->code;
});
?>

<div class="grow flex flex-col justify-center">
    <div class="text-black grid grid-cols-1 gap-8 sm:gap-10 dark:text-white">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-10 text-center font-bold text-xl lg:text-2xl">
            <div class="bg-white dark:bg-black border border-white rounded-3xl py-4 lg:py-6">Student ID: {{$id}}</div>
            <div class="bg-white dark:bg-black border border-white rounded-3xl py-4 lg:py-6">{{Gate::check('is_Admin') ? 'NA' : $days_remaining}}</div>
            <div class="bg-white dark:bg-black border border-white rounded-3xl py-4 lg:py-6">Total Income: ${{$user->referral_income + $user->task_income}}</div>
        </div>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-10 text-center font-bold text-xl lg:text-2xl">
            <div class="bg-white dark:bg-black border border-white rounded-3xl py-4 lg:py-6">Referral Income: ${{$user->referral_income}}</div>
            <div class="bg-white dark:bg-black border border-white rounded-3xl py-4 lg:py-6">Task Income: ${{$user->task_income}}</div>
        </div>
        <div x-data="copyToClipboard" x-init='text = `{{str_replace("dashboard","sign-up/",$url)}}{{$referral_code}}`;' class="bg-white dark:bg-black border border-white rounded-3xl py-6 px-2 text-center font-bold select-text flex items-center justify-center gap-2">
            <div x-text="'Refer: ' + text"></div>
            <button @click="copy" class="rounded-full hover:bg-white/50 p-1 group">
                <div x-show="!copied">
                    <svg class="size-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-5-4v4h4V3h-4Z" />
                    </svg>
                </div>
                <div x-show="copied">
                    <svg class="size-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                    </svg>
                </div>
            </button>
        </div>
    </div>
</div>