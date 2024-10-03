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

<div class="bg-[#050e14] select-none">
    <livewire:style.landing-page-style />
    <livewire:modals.modal-landing-page-list />
    @if (in_array($path,['/','terms-and-conditions','privacy-policy','join-success','join-failure','refund-and-cancellation-policy']))
    <div>
        @if($path == '/')
        <livewire:navbar />
        <livewire:landing-page-chat-option />
        <livewire:landing-page />
        @elseif($path == 'terms-and-conditions')
        <livewire:terms-and-conditions />
        @elseif($path == 'privacy-policy')
        <livewire:privacy-policy />
        @elseif($path == 'refund-and-cancellation-policy')
        <livewire:refund-and-cancellation-policy />
        @elseif($path == 'join-success')
        <livewire:payment.join-success :transaction="$transaction" />
        @elseif($path == 'join-failure')
        <livewire:payment.join-failure :transaction="$transaction" />
        @endif
    </div>
    @elseif($path == 'sign-up' || $path == 'log-in')
    <div class="flex justify-between">
        <div class="w-2/5 max-lg:hidden"></div>

        @if ($path == 'sign-up')
        <livewire:sign-up :referral_code="$referral_code" />
        @elseif($path == 'log-in')
        <livewire:log-in />
        @endif
    </div>
    @endif
</div>