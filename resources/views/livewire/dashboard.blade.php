<?php

use function Livewire\Volt\{state, mount};

use App\Models\LkUserPlan;
use App\Models\ReferralCode;
use App\Models\ReferralIncome;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


state(['id', 'balance', 'days_remaining', 'expiry_date', 'referral_code', 'referral_income']);

mount(function () {
    $this->id = Auth::user()->id;
    $this->balance = Wallet::where('user_id', $this->id)->first()->amount;
    $this->expiry_date = LkUserPlan::where('user_id', $this->id)->first()->expiry_date;
    $this->days_remaining = (int)Carbon::now()->diffInDays($this->expiry_date);
    $this->referral_code = ReferralCode::where('user_id', $this->id)->first()->code;
    $this->referral_income = ReferralIncome::where('user_id', $this->id)->first()->amount;
});
?>

<div class="text-[#131e30] grid grid-cols-1 gap-8">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-3 text-center font-bold text-xl lg:text-2xl">
        <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">Student ID: {{$id}}</div>
        <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">{{$days_remaining}} Days</div>
        <div class="bg-[#d6dcde] rounded-2xl py-8 lg:py-12">Wallet: ${{$balance}}</div>
    </div>
    <div class="bg-[#d6dcde] rounded-2xl py-12 px-2 text-center font-bold">Referral Income: ${{$referral_income}}</div>
    <div class="bg-[#d6dcde] rounded-2xl py-12 px-2 text-center font-bold">Referral Code: {{$referral_code}}</div>
</div>