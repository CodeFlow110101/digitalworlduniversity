<?php

use function Livewire\Volt\{state, mount};

use App\Models\LkUserPlan;
use App\Models\Plan;
use App\Models\ReferralCode;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

state(['email', 'password']);

$login = function (Request $request) {

    Auth::attempt([
        'email' => $this->email,
        'password' => $this->password,
    ]);

    $request->session()->regenerate();
    $this->redirectRoute('dashboard', navigate: true);
};

mount(function ($transaction) {
    $this->email = $transaction['cus_email'];
    $this->password = $transaction['opt_a'];


    $user = User::create([
        'name' => $transaction['cus_name'],
        'email' => $transaction['cus_email'],
        'password' => Hash::make($transaction['opt_a']),
        'phone_no' => $transaction['cus_phone'],
        'role_id' => Role::where('name', 'student')->first()->id,
    ]);

    $currentDate = Carbon::now();

    LkUserPlan::create([
        'user_id' => $user->id,
        'plan_id' => $transaction['opt_c'],
        'expiry_date' => $currentDate->addMonths(Plan::find($transaction['opt_c'])->period),
    ]);

    ReferralCode::create([
        'user_id' => $user->id,
        'code' => (string) Str::uuid() . $user->id . $user->name,
    ]);

    if ($transaction['opt_b'] && ReferralCode::where('code', $transaction['opt_b'])->exists()) {
        $plan_price = Plan::find($this->plan)->price;
        $user_id = ReferralCode::where('code', $transaction['opt_b'])->first('user_id')->user_id;
        User::where('id', $user_id)->increment('wallet', $plan_price * 0.25);
        User::where('id', $user_id)->increment('referral_income', $plan_price * 0.25);
    }

    unset($transaction['opt_a']);
    unset($transaction['opt_b']);
    unset($transaction['opt_c']);
    unset($transaction['opt_d']);
    $transaction['user_id'] = $user->id;
    Transaction::create($transaction);
});

?>

<div class="bg-black h-dvh w-full flex justify-center items-center">
    <div class="h-min relative grid grid-cols-1 gap-2 text-[#f6aa23] border-4 border-[#f6aa23] rounded-xl p-6 pt-10">
        <div class="absolute -top-8 w-full flex justify-center">
            <div class="rounded-full p-4 bg-green-500  w-min">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 11.917 9.724 16.5 19 7.5" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-semibold py-4">Payment Successful</div>
        <div class="">
            <div class="text-center text-lg font-semibold">Your login Credentials</div>
        </div>
        <div class="h-min grid grid-cols-1 gap-1 text-center">
            <div>Email: {{$email}}</div>
            <div>Password: {{$password}}</div>
        </div>
        <div class="px-4 pt-4">
            <div wire:click="login" class="text-white cursor-pointer font-semibold text-lg text-center bg-[#f6aa23] rounded-lg p-2">Login</div>
        </div>
    </div>
</div>