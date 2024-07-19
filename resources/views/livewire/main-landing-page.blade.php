<?php

use function Livewire\Volt\{state, layout, mount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


state(['path']);
layout('components.layouts.app');

mount(function (Request $request) {
    $this->path = $request->path();

    if (($this->path == 'log-in' || $this->path == 'sign-up') && Auth::check()) {
        $this->redirectRoute('dashboard', navigate: true);
    }
});

?>

<div class="bg-[#050e14]">
    <livewire:style.landing-page-style>

        @if ($path == '/')
        <div>
            <livewire:navbar>
                <livewire:landing-page-chat-option>
                    <livewire:landing-page>
        </div>


        @elseif($path == 'sign-up' || $path == 'log-in')
        <div class="flex justify-between">
            <div class="w-2/5 max-lg:hidden"></div>
            @if ($path == 'sign-up')

            <livewire:sign-up>

                @elseif($path == 'log-in')
                <livewire:log-in>
                    @endif
        </div>
        @endif
</div>