<?php

use function Livewire\Volt\{state, layout, mount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


state(['path', 'query_param', 'transaction']);
state(['referral_code'])->url();

layout('components.layouts.app');

mount(function (Request $request) {

    $this->path = $request->path();

    if (($this->path == 'log-in' || $this->path == 'sign-up') && Auth::check()) {
        return $this->redirectRoute('dashboard', navigate: true);
    }

    if ($this->path == 'join-success' && session()->has('transaction')) {
        $this->transaction = session()->get('transaction');
    }

    if ($this->path == 'join-success' && !session()->has('transaction')) {
        return $this->redirectRoute('sign-up', navigate: true);
    }

    if ($this->path == 'join-failure' && session()->has('transaction')) {
        $this->transaction = session()->get('transaction');
    }

    if ($this->path == 'join-failure' && !session()->has('transaction')) {
        return $this->redirectRoute('sign-up', navigate: true);
    }
});

?>

<div class="bg-black h-dvh select-none">
    <livewire:style.landing-page-style />
    <livewire:modals.modal-landing-page-list />
    @if (in_array($path,['/','terms-and-conditions','contact','privacy-policy','join-success','join-failure','refund-and-cancellation-policy']))
    <div>
        @if($path == '/')
        <livewire:navbar />
        <livewire:landing-page-chat-option />
        <livewire:home />
        @elseif($path == 'terms-and-conditions')
        <livewire:terms-and-conditions />
        @elseif($path == 'privacy-policy')
        <livewire:privacy-policy />
        @elseif($path == 'contact')
        <livewire:contact />
        @elseif($path == 'refund-and-cancellation-policy')
        <livewire:refund-and-cancellation-policy />
        @elseif($path == 'join-success')
        <livewire:payment.join-success :transaction="$transaction" />
        @elseif($path == 'join-failure')
        <livewire:payment.join-failure :transaction="$transaction" />
        @endif
    </div>
    @elseif($path == 'sign-up' || $path == 'log-in')
    <div class="flex justify-between h-full">
        <div class="grow w-2/5 max-lg:hidden flex flex-col">
            <img class="m-auto w-11/12 rounded-xl" src="{{asset('images/logo.jpeg')}}">
        </div>

        <div class="overflow-y-auto max-h-[100vh] lg:w-3/5 w-full">
            @if ($path == 'sign-up')
            <livewire:sign-up :referral_code="$referral_code" />
            @elseif($path == 'log-in')
            <livewire:log-in />
            @endif
        </div>
    </div>
    @endif
</div>