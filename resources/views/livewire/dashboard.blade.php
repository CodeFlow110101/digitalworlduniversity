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
    $this->days_remaining = (int)Carbon::now()->diffInDays($this->expiry_date);
    $this->referral_code = ReferralCode::where('user_id', $this->id)->first()->code;
});
?>

<div class="text-[#131e30] grid grid-cols-1 gap-8 sm:gap-20 dark:text-[#DDE6ED]">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-20 text-center font-bold text-xl lg:text-2xl">
        <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-8 lg:py-12">Student ID: {{$id}}</div>
        <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-8 lg:py-12">{{$days_remaining}} Days Till Expiry</div>
        <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-8 lg:py-12">Total Income: ${{$user->referral_income + $user->task_income}}</div>
    </div>
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-20 text-center font-bold text-xl lg:text-2xl">
        <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-8 lg:py-12">Referral Income: ${{$user->referral_income}}</div>
        <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-8 lg:py-12">Task Income: ${{$user->task_income}}</div>
    </div>
    <div class="bg-[#d6dcde] dark:bg-[#27374D] rounded-2xl py-12 px-2 text-center font-bold select-text">Refer: {{str_replace("dashboard","sign-up/?referral_code=",$url)}}{{$referral_code}}</div>
</div>