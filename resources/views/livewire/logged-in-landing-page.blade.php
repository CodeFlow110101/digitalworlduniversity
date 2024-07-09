<?php

use function Livewire\Volt\{state, layout};

layout('components.layouts.app');

?>

<div class="h-dvh flex justify-between bg-[#050e14]">
    <div class="w-3/12"><livewire:logged-in-side-bar></div>
    <div class="w-9/12">
        <div class="py-8 text-3xl text-center text-[#f6aa23] font-bold">Dashboard</div>
    </div>
</div>
