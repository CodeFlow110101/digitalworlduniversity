<?php

use function Livewire\Volt\{state, layout, mount};
use Illuminate\Http\Request;

state(['path']);
layout('components.layouts.app');

mount(function (Request $request) {
    $this->path = $request->path();
});

?>

<div class="bg-[#050e14]">
    @if ($path == '/')
        <livewire:navbar>
            <livewire:landing-page-chat-option>
                <livewire:landing-page>
                @elseif($path == 'sign-up')
                    <div class="flex justify-between">
                        <div class="w-2/5"></div>
                        <livewire:sign-up>
                    </div>
    @endif
</div>
