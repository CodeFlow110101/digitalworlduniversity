<?php

use function Livewire\Volt\{state, rules, mount};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

state(['email', 'password']);

rules(['password' => 'required', 'email' => 'required|email']);

$redirectTo = function () {
    $this->redirectRoute('landing-page', navigate: true);
};

$submit = function (Request $request) {
    $this->validate();

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
};

?>

<div class="lg:w-3/5 w-full h-dvh bg-black py-10 sm:px-10 px-8">
    <div class="grid grid-cols-1 gap-2 max-sm:text-center">
        <div class="text-white sm:text-3xl text-2xl font-bold uppercase">Digital Worlds University</div>
        <div class="text-white sm:text-2xl text-xl font-normal uppercase">Login</div>
    </div>

    <div class="mt-12 grid grid-cols-1 sm:gap-16 gap-8">
        <div class="sm:px-8 grid grid-cols-1 gap-8 mt-4">
            <div class="grid grid-cols-1 sm:gap-4 gap-2">
                <div class="text-gray-400">Email Address</div>
                <input wire:model="email" type="email"
                    class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400 text-gray-400 text-lg"
                    placeholder="example@gmail.com">
                <div>
                    @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div class="text-gray-400">Password</div>
                <input wire:model="password" type="password"
                    class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400 text-gray-400 text-lg">
                <div>
                    @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div wire:click="submit" wire:loading.class="pointer-events-none" wire:target="submit"
                class="sm:mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-white font-bold transition-colors duration-500 bg-[#f6aa23]">
                <div wire:loading.class="hidden" wire:target="submit">Login</div>
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
</div>