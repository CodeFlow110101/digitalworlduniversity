<?php

use function Livewire\Volt\{state, rules, mount};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

state(['email', 'password']);

rules(['password' => 'required', 'email' => 'required|email']);

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

<div class="w-3/5 h-dvh bg-black p-10">
    <div class="grid grid-cols-1 gap-2">
        <div class="text-white text-3xl font-bold uppercase">Digital Worlds University</div>
        <div class="text-white text-2xl font-normal uppercase">Login</div>
    </div>

    <div class="mt-12 grid grid-cols-1 gap-16">

        <div class="px-8 grid grid-cols-1 gap-8 mt-4">
            <div class="grid grid-cols-1 gap-4">
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
                <input wire:model="password" type="text"
                    class="rounded-lg w-full px-4 py-4 bg-transparent border border-gray-400 text-gray-400 text-lg">
                <div>
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div wire:click="submit"
            class="mx-8 py-4 text-center text-xl px-4 cursor-pointer tracking-wider border border-[#f6aa23] transition-opacity duration-300 hover:opacity-80 rounded-lg text-white font-bold transition-colors duration-500 bg-[#f6aa23]">
            Login</div>
    </div>
</div>
