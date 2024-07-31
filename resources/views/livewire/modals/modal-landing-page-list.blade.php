<?php

use function Livewire\Volt\{state, on};

state(['show_modal', 'modal' => "add-job", 'args', 'data', 'callback_event']);

on([
    'show-modal' => function ($modal, $args, $data, $callback_event) {
        $this->show_modal = true;
        $this->modal = $modal;
        $this->args = $args;
        $this->data = $data;
        $this->callback_event = $callback_event;
    },
    'hide-modal' => function () {
        $this->reset(['show_modal', 'modal', 'args', 'data', 'callback_event']);
    },
]);

?>

<div class="h-full w-full fixed z-10 top-0 bg-black/50 @if(!$show_modal) hidden @endif flex justify-center items-center">
    <div class="bg-gray-700 @if($show_modal && $modal == 'modal-landing-page-program-preview') w-3/4 sm:w-1/2 lg:w-1/4 @else w-1/2 @endif p-6 sm:p-6 rounded-2xl grid grid-cols-1 gap-4 sm:gap-12">
        <div class="flex justify-between items-center">
            <div class="text-[#f6aa23] capitalize text-lg sm:text-2xl font-bold">Course</div>
            <div wire:click="$dispatch('hide-modal')" class="hover:bg-gray-400 p-2 rounded-full cursor-pointer">
                <svg class="w-6 h-6 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>
        </div>
        @if($show_modal && $modal == 'modal-landing-page-program-preview')
        <livewire:modals.modal-landing-page-program-preview :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
            @endif
    </div>
</div>