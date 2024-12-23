<?php

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalStatus;
use Illuminate\Database\Eloquent\Builder;

use function Livewire\Volt\{state, with};

with(fn() => ['withdrawals' => Withdrawal::with(['user', 'method', 'status'])->whereHas('status', function (Builder $query) {
    $query->where('name', '!=', 'rejected');
})->get()]);

$reject = function ($id) {

    $withdrawal = Withdrawal::find($id);
    $withdrawal->update([
        'status_id' => 2,
    ]);

    $withdrawal->user->increment('wallet', $withdrawal->amount);
};

$accept = function ($id) {
    $withdrawal = Withdrawal::find($id);
    $withdrawal->update([
        'status_id' => 3,
    ]);
};

$passed = function ($id) {
    $withdrawal = Withdrawal::find($id);
    $withdrawal->update([
        'status_id' => 4,
    ]);
};


?>

<div class="h-dvh relative" x-data="{ height: 0 , tabHeight: 0}" x-resize="height = $height">
    <div class="gap-6 p-6 grid grid-cols-2 sm:grid-cols-4 overflow-y-auto" :style="'height: ' + height + 'px;'">
        @foreach($withdrawals as $withdrawal)
        <div class="flex flex-col gap-2" :style="'height: ' + tabHeight + 'px;'">
            <div class="relative grow rounded-3xl overflow-hidden">
                <div class="size-full flex flex-col">
                    <div class="grow flex justify-stretch">
                        <div class="bg-gradient-to-br from-white via-transparent via-35% size-full"></div>
                        <div class="bg-gradient-to-bl from-white via-transparent via-35% size-full"></div>
                    </div>
                    <div class="grow flex justify-stretch">
                        <div class="bg-gradient-to-tr from-white via-transparent via-35% size-full"></div>
                        <div class="bg-gradient-to-tl from-white via-transparent via-35% size-full"></div>
                    </div>
                </div>
                <div class="absolute inset-0.5 p-1 bg-black rounded-3xl overflow-hidden flex flex-col justify-evenly items-center text-white">
                    <div>{{ $loop->iteration }} :</div>
                    <div>Name : {{ $withdrawal->user->name }}</div>
                    <div>Email : {{ $withdrawal->user->email }}</div>
                    <div>Withdrawal Rqst : {{ $withdrawal->amount }}</div>
                    <div>Payment Method : {{ $withdrawal->method->name }}</div>
                    <div>Payment Id : {{ $withdrawal->payment_id }}</div>
                    <div class="flex justify-evenly items-center w-full">
                        @if($withdrawal->status->name == 'open')
                        <button wire:click="reject({{ $withdrawal->id }})" class="text-sm bg-red-500 rounded-full py-1 px-2 uppercase">reject</button>
                        @endif
                        @if($withdrawal->status->name == 'open')
                        <button wire:click="accept({{ $withdrawal->id }})" class="text-sm bg-green-500 rounded-full py-1 px-2 uppercase">accept</button>
                        @elseif($withdrawal->status->name == 'passed')
                        <button wire:click="passed({{ $withdrawal->id }})" class="text-sm bg-green-500 rounded-full py-1 px-2 uppercase">{{$withdrawal->status->name}}</button>
                        @else
                        <div class="text-sm bg-green-500 rounded-full py-1 px-2 uppercase">{{$withdrawal->status->name}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-white bg-white absolute inset-0 p-6 flex flex-col gap-6 opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>