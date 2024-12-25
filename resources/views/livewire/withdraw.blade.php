<?php

use App\Models\User;
use App\Models\WithdrawalMethod;
use App\Models\WithdrawalStatus;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;

use function Livewire\Volt\{rules, state, with};

state(['amount', 'name', 'email', 'method', 'payment_id', 'user' => User::find(Auth::user()->id)]);

rules(fn() => ['amount' => ['required', 'lt:' . $this->user->wallet], 'name' => 'required', 'email' => 'required|email', 'method' => 'required', 'payment_id' => 'required']);

with(fn() => ['withdrawalmethods' => WithdrawalMethod::get()]);

$submit = function () {
    $this->validate();

    User::find($this->user->id)->withdrawals()->create([
        'amount' => $this->amount,
        'name' => $this->name,
        'email' => $this->email,
        'method_id' => $this->method,
        'payment_id' => $this->payment_id,
        'status_id' => WithdrawalStatus::where('name', 'open')->first()->id,
    ]);

    User::find($this->user->id)->decrement('wallet', $this->amount);

    $this->reset(['amount', 'name', 'email', 'method', 'payment_id']);
};
?>

<div class="grow flex flex-col gap-2 p-2 lg:p-6 text-white text-sm lg:text-base">
    <div class="bg-black p-2 w-min whitespace-nowrap rounded-full">Available Balance : $ {{$user->wallet}}</div>
    <form class="grow border border-black rounded-lg flex flex-col justify-evenly max-lg:px-2" wire:submit="submit">
        <div class="mx-auto bg-black rounded-full p-2">Whithdrawal Balance</div>
        <div class="mx-auto bg-black rounded-full py-2 px-4 flex gap-2 lg:w-1/2 w-full">
            <div>Amount:</div>
            <input wire:model="amount" x-mask="999999999" class="outline-none bg-transparent w-full">
        </div>
        <div class="mx-auto"> @error('amount')<div class="text-red-600">{{$message}}</div>@enderror</div>
        <div class="mx-auto bg-black rounded-full py-2 px-4 flex gap-2 lg:w-1/2 w-full">
            <div>Name:</div>
            <input wire:model="name" class="outline-none bg-transparent w-full">
        </div>
        <div class="mx-auto"> @error('name')<div class="text-red-600">{{$message}}</div>@enderror</div>
        <div class="mx-auto bg-black rounded-full py-2 px-4 flex gap-2 lg:w-1/2 w-full">
            <div>Email:</div>
            <input wire:model="email" class="outline-none bg-transparent w-full">
        </div>
        <div class="mx-auto"> @error('email')<div class="text-red-600">{{$message}}</div>@enderror</div>
        <div class="mx-auto bg-black rounded-full py-2 px-4 flex gap-2 lg:w-1/2 w-full">
            <div>Method:</div>
            <select wire:model="method" class="outline-none bg-transparent w-full capitalize">
                <option value="" selected>select a withdrawal method</option>
                @foreach($withdrawalmethods as $withdrawalmethod)
                <option value="{{ $withdrawalmethod->id }}">{{ $withdrawalmethod->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mx-auto"> @error('method')<div class="text-red-600">{{$message}}</div>@enderror</div>
        <div class="mx-auto bg-black rounded-full py-2 px-4 flex gap-2 lg:w-1/2 w-full">
            <div class="whitespace-nowrap">Payment Id:</div>
            <input wire:model="payment_id" class="outline-none bg-transparent w-full">
        </div>
        <div class="mx-auto"> @error('payment_id')<div class="text-red-600">{{$message}}</div>@enderror</div>
        <div class="bg-blue-600/80 w-min mx-auto rounded-full border-2 border-black">
            <button type="submit" class="bg-blue-600 mx-auto -translate-y-1.5 hover:translate-y-0 transition-transform duration-200 py-2 px-6 text-lg rounded-full">
                Submit
            </button>
        </div>
    </form>
</div>