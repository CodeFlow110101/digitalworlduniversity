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
use Illuminate\Support\Facades\Http;

use function Livewire\Volt\{state, with, rules, mount};

state(['email', 'name', 'password', 'plan', 'phone_no', 'termsAndConditions', 'password_confirmation', 'referral_code']);

rules(['name' => 'required|min:3', 'email' => 'required|email|unique:users,email', 'phone_no' => 'required|digits:10', 'termsAndConditions' => 'required|accepted', 'password' => 'required|min:6|confirmed', 'plan' => 'required']);


with(fn() => ['plans' => Plan::paginate(0)]);

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

$submit = function (Request $request) {
    $this->validate();

    $plan = Plan::find($this->plan);

    $response = json_decode(Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('AAMAR_PAY_URL'), [
        "store_id" => env('AAMAR_PAY_STORE_ID'),
        "tran_id" => Str::uuid() . Carbon::now()->timestamp,
        "success_url" => url('/payment-success'),
        "fail_url" => url('/payment-fail'),
        "cancel_url" => url('/sign-up'),
        "amount" => $plan->price,
        "currency" => "BDT",
        "signature_key" => env('AAMAR_PAY_SIGNATURE_KEY'),
        "desc" => 'Subscription Plan: ' . $plan->name,
        "cus_name" => $this->name,
        "cus_email" => $this->email,
        "cus_add1" => "",
        "cus_add2" => "",
        "cus_city" => "",
        "cus_state" => "",
        "cus_postcode" => "",
        "cus_country" => "Bangladesh",
        "cus_phone" => $this->phone_no,
        "type" => "json",
        'opt_a' => $this->password,
        'opt_b' => $this->referral_code,
        'opt_c' => $this->plan,
        'opt_d' => '',
    ])->body());

    if ($response->result) {
        return redirect()->away($response->payment_url);
    } else {
        dd('Somethong went');
    }
};

mount(function ($referral_code) {
    $this->referral_code = $referral_code;
});

?>

<div class="bg-black py-10 px-3 md:px-10 ">
    <div class="grid grid-cols-1 gap-2 max-md:text-center">
        <div class="text-white text-3xl font-bold uppercase">Join Digital World University</div>
        <div class="text-white text-2xl font-normal uppercase">Escape the Matrix - Escape the Slavery</div>
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
            @error('email')<div wire:transition class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Name</div>
            <div><input type="email" wire:model="name" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="Name"></div>
            @error('name')<div wire:transition class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Phone No</div>
            <div><input x-mask="9999999999" wire:model="phone_no" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400" placeholder="Phone No"></div>
            @error('phone_no')<div wire:transition class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Password</div>
            <div><input type="password" wire:model="password" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400"></div>
            @error('password')<div wire:transition class="text-red-600">{{$message}}</div>@enderror

            <div class="text-gray-400">Confirm Password</div>
            <div><input type="password" wire:model="password_confirmation" class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400"></div>
            @error('password_confirmation')<div wire:transition class="text-red-600">{{$message}}</div>@enderror
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
            <div @click="$refs.plan{{$plan_option->id}}.click();" class="w-full @if($plan_option->id == $plan) border-2 border-amber-500 @endif bg-gray-700 grid grid-cols-1 px-2 md:px-5 py-4 gap-4 rounded-lg">
                <div class="font-bold text-white text-2xl inline-flex items-center">
                    <div>
                        <img width="30" height="30" src="https://img.icons8.com/external-ios-line-2px-amoghdesign/30/FFFFFF/external-bangladesh-currency-minima-30px-ios-line-2px-amoghdesign.png" alt="external-bangladesh-currency-minima-30px-ios-line-2px-amoghdesign" />
                    </div>
                    <div>{{$plan_option->price}}/<span class="text-base">{{$plan_option->period}} Month</span></div>
                </div>
                <input type="radio" x-ref="plan{{$plan_option->id}}" value="{{$plan_option->id}}" wire:model.live="plan" class="hidden">
                <div class="text-2xl text-left text-white capitalize">{{$plan_option->name}}</div>
                <div class="grid grid-cols-1 gap-2 h-min text-sm">
                    <div class="inline-flex gap-2">
                        <div>
                            <svg class="w-6 h-6 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                        </div>
                        <div class="text-gray-300">
                            Get access to all course
                        </div>
                    </div>
                    <div class="inline-flex gap-2">
                        <div>
                            <svg class="w-6 h-6 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                        </div>
                        <div class="text-gray-300">
                            Connect your self with same minded people direct advice and guide from the mentor
                        </div>
                    </div>
                    <div class="inline-flex gap-2">
                        <div>
                            <svg class="w-6 h-6 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                        </div>
                        <div class="text-gray-300">
                            Subscription period {{$plan_option->period}} month{{$plan_option->period != 1 ? 's' : ''}}.
                        </div>
                    </div>
                </div>
                <div class="w-full mt-8 md:mt-20 text-center align-middle font-semibold uppercase py-2 rounded-lg @if($plan_option->id == $plan) bg-amber-500 font-bold @else bg-gray-500 text-white @endif">
                    @if($plan_option->id == $plan)
                    Select
                    @else
                    choose plan
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @error('plan')<div wire:transition class="text-red-600">{{$message}}</div>@enderror
    </div>
    <div class="mt-12">
        <div class="flex items-start mb-4">
            <input wire:model="termsAndConditions" type="checkbox" class="w-5 h-5 outline-none  accent-amber-500 bg-gray-100 border-gray-300 rounded">
            <label for="default-checkbox" class="ms-2 font-medium text-amber-500">I've read and accept the <span wire:click="redirectTo('terms-and-conditions')" class="underline cursor-pointer">
                    Terms & Conditions
                </span>,
                <span wire:click="redirectTo('refund-and-cancellation-policy')" class="underline cursor-pointer">
                    Refund and Cancellation Policy
                </span>
                &<span wire:click="redirectTo('privacy-policy')" class="underline cursor-pointer">
                    Privacy Policy
                </span>
            </label>
        </div>
        @error('termsAndConditions')<div wire:transition class="text-red-600">{{$message}}</div>@enderror
    </div>
    <div class="mt-12 flex justify-around">
        <div wire:click="submit" wire:loading.class="pointer-events-none" wire:target="submit"
            class="w-full sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-amber-500 transition-opacity duration-300 rounded-lg text-white font-bold transition-colors duration-500 bg-amber-500">
            <div wire:loading.class="hidden" wire:target="submit">Join</div>
            <div wire:loading.class.remove="hidden" wire:target="submit" class="flex justify-center hidden">
                <svg aria-hidden="true" class="w-8 h-8 text-black animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>
        </div>
        <a href="/" wire:navigate class="sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-amber-500 hover:text-white hover:bg-amber-500 transition-opacity duration-300 rounded-lg text-amber-500 font-bold transition-colors duration-500">
            Back
        </a>
    </div>
</div>