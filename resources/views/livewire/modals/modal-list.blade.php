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

<div class="h-full w-full fixed top-0 bg-black/50 @if(!$show_modal) hidden @endif flex justify-center items-center">
    <div class="bg-[#d6dcde] dark:bg-gray-800 @if($show_modal && $modal == 'modal-program-preview') w-3/4 sm:w-1/2 lg:w-1/4 @else w-1/2 @endif p-6 sm:p-10 rounded-2xl grid grid-cols-1 gap-4 sm:gap-12">
        <div class="flex justify-between items-center">
            <div class="text-[#131e30] dark:text-[#DDE6ED] capitalize text-lg sm:text-2xl font-bold">{{str_replace('modal','',str_replace("-"," ",$modal))}}</div>
            <div wire:click="$dispatch('hide-modal')" class="hover:bg-gray-400 p-2 rounded-full cursor-pointer">
                <svg class="w-6 h-6 text-gray-800 dark:text-[#DDE6ED] dark:hover:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>
        </div>
        @if($show_modal && $modal == 'add-job')
        <livewire:modals.modal-add-job :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
            @elseif($show_modal && $modal == 'modal-user')
            <livewire:modals.modal-user :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                @elseif($show_modal && $modal == 'modal-programs')
                <livewire:modals.modal-programs :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                    @elseif($show_modal && $modal == 'modal-video')
                    <livewire:modals.modal-video :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                        @elseif($show_modal && $modal == 'modal-store')
                        <livewire:modals.modal-store :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                            @elseif($show_modal && $modal == 'modal-earn-money')
                            <livewire:modals.modal-earn-money :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                @elseif($show_modal && $modal == 'modal-update-user')
                                <livewire:modals.modal-update-user :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                    @elseif($show_modal && $modal == 'modal-reset-password')
                                    <livewire:modals.modal-reset-password :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                        @elseif($show_modal && $modal == 'modal-program-preview')
                                        <livewire:modals.modal-program-preview :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                            @elseif($show_modal && $modal == 'modal-channels')
                                            <livewire:modals.modal-channels :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                                @elseif($show_modal && $modal == 'modal-group')
                                                <livewire:modals.modal-group :modal="$modal" :args="$args" :data="$data" :callback_event="$callback_event">
                                                    @endif
    </div>
</div>