<?php

use App\Models\LkUserPlan;
use App\Models\Plan;
use App\Models\ReferralCode;
use App\Models\ReferralIncome;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function Livewire\Volt\{state, with, rules, mount};

state(['email', 'name', 'password', 'plan', 'password_confirmation', 'referral_code']);

rules(['name' => 'required|min:3', 'email' => 'required|email|unique:users,email', 'password' => 'required|min:6|confirmed', 'plan' => 'required']);


with(fn() => ['plans' => Plan::paginate(0)]);

$redirectTo = function () {
    $this->redirectRoute('landing-page', navigate: true);
};

$submit = function (Request $request) {
    $this->validate();

    $user = User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password),
        'role_id' => Role::where('name', 'student')->first()->id,
    ]);

    $currentDate = Carbon::now();

    LkUserPlan::create([
        'user_id' => $user->id,
        'plan_id' => $this->plan,
        'expiry_date' => $currentDate->addMonths(3),
    ]);

    ReferralCode::create([
        'user_id' => $user->id,
        'code' => (string) Str::uuid() . $user->id . $user->name,
    ]);

    if ($this->referral_code && ReferralCode::where('code', $this->referral_code)->exists()) {
        $plan_price = Plan::find($this->plan)->price;
        $user_id = ReferralCode::where('code', $this->referral_code)->first('user_id')->user_id;
        User::where('id', $user_id)->increment('wallet', $plan_price * 0.25);
        User::where('id', $user_id)->increment('referral_income', $plan_price * 0.25);
    }

    if (
        Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])
    ) {
        $request->session()->regenerate();

        $this->redirectRoute('dashboard', navigate: true);
    } else {
        $this->addError('email', 'Invalid Credentials');
    }

    $this->dispatch('hide-modal');
    $this->dispatch('reset-admin-panel-users');
};

mount(function ($referral_code) {
    $this->referral_code = $referral_code;
});

?>

<div class="lg:w-3/5 w-full bg-black py-10 px-3 md:px-10 ">
    <div class="grid grid-cols-1 gap-2 max-md:text-center">
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
        <div class="px-8 grid grid-cols-1 gap-3 mt-4 text-white">
            <div class="text-gray-400">Email Address</div>
            <div><input type="email" wire:model="email" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="example@gmail.com"></div>
            @error('email')<div class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Name</div>
            <div><input type="email" wire:model="name" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="Name"></div>
            @error('name')<div class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Password</div>
            <div><input type="password" wire:model="password" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400"></div>
            @error('password')<div class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Confirm Password</div>
            <div><input type="password" wire:model="password_confirmation" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400"></div>
            @error('password_confirmation')<div class="text-red-600">{{$message}}</div>@enderror
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 mt-6">
            @foreach($plans as $plan_option)
            <div @click="$refs.plan{{$plan_option->id}}.click();" class="w-full @if($plan_option->id == $plan) border-2 border-[#f6aa23] @endif bg-gray-700 grid-cols-1 px-2 md:px-5 py-4 gap-4 rounded-lg">
                <div class="font-bold text-white text-2xl">${{$plan_option->price}}<span class="text-xl text-gray-300 font-normal">/
                        monthly</span>
                </div>
                <input type="radio" x-ref="plan{{$plan_option->id}}" value="{{$plan_option->id}}" wire:model.live="plan" class="hidden">
                <div class="text-2xl text-left text-white">{{$plan_option->name}}</div>
                <div class="w-full mt-8 md:mt-48 text-center align-middle font-semibold uppercase py-2 rounded-lg @if($plan_option->id == $plan) bg-[#f6aa23] font-bold @else bg-gray-500 text-white @endif">
                    @if($plan_option->id == $plan)
                    Select
                    @else
                    choose plan
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @error('plan')<div class="text-red-600">{{$message}}</div>@enderror
    </div>
    <div class="mt-12 grid grid-cols-1 gap-6">
        <div wire:click="submit" wire:loading.class="pointer-events-none" wire:target="submit"
            class="sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 rounded-lg text-white font-bold transition-colors duration-500 bg-[#f6aa23]">
            <div wire:loading.class="hidden" wire:target="submit">Join</div>
            <div wire:loading.class.remove="hidden" wire:target="submit" class="flex justify-center hidden">
                <svg aria-hidden="true" class="w-8 h-8 text-[#131e30] animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>
        </div>
        <div wire:click="redirectTo"
            class="sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-[#f6aa23] hover:text-white hover:bg-[#f6aa23] transition-opacity duration-300 rounded-lg text-[#f6aa23] font-bold transition-colors duration-500">
            Back
        </div>
    </div>
</div>