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

<div class="text-[#131e30] grid grid-cols-1 gap-8 sm:gap-10 dark:text-[#DDE6ED]">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-10 text-center font-bold text-xl lg:text-2xl">
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-4 lg:py-6">Student ID: {{$id}}</div>
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-4 lg:py-6">{{Gate::check('is_Admin') ? 'NA' : $days_remaining}}</div>
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-4 lg:py-6">Total Income: ${{$user->referral_income + $user->task_income}}</div>
    </div>
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-10 text-center font-bold text-xl lg:text-2xl">
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-4 lg:py-6">Referral Income: ${{$user->referral_income}}</div>
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-4 lg:py-6">Task Income: ${{$user->task_income}}</div>
    </div>
    <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-3xl py-6 px-2 text-center font-bold select-text">Refer: {{str_replace("dashboard","sign-up/?referral_code=",$url)}}{{$referral_code}}</div>
</div>