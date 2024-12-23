<?php

use function Livewire\Volt\{state};

//

?>

<div class="h-dvh flex flex-col p-4">
    <div class="relative grow" x-data="{ height: 0 }" x-resize="height = $height">
        <img src="{{ asset('images/ai_tutor_baner.jpg') }}" :style="'height: ' + height + 'px;'" class="w-full absolute rounded-xl">
        <div class="absolute inset-0 rounded-xl bg-black/50 text-white flex justify-center items-center text-4xl font-extralight">
            Comming soon
        </div>
    </div>
</div>
