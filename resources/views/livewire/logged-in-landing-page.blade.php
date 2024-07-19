<?php

use function Livewire\Volt\{state, layout, mount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

layout('components.layouts.app');

state(['path', 'id']);

mount(function (Request $request) {
    $this->path = $request->path();

    if (!Auth::check()) {
        $this->redirectRoute('landing-page', navigate: true);
    }

    if (Gate::check('is_Student') && str_contains($this->path, 'admin-panel')) {
        $this->redirectRoute('dashboard', navigate: true);
    }

    if ($this->path == 'admin-panel-videos' && session()->has('admin-panel-video-id')) {
        $this->id = session()->get('admin-panel-video-id');
    }
    if ($this->path == 'admin-panel-videos' && !session()->has('admin-panel-video-id')) {
        $this->redirectRoute('admin-panel-programs', navigate: true);
    }

    if ($this->path == 'admin-panel-video-player' && session()->has('admin-panel-video-player-id')) {
        $this->id = session()->get('admin-panel-video-player-id');
    }
    if ($this->path == 'admin-panel-video-player' && !session()->has('admin-panel-video-player-id')) {
        $this->redirectRoute('admin-panel-programs', navigate: true);
    }

    if ($this->path == 'videos' && session()->has('videos-id')) {
        $this->id = session()->get('videos-id');
    }
    if ($this->path == 'videos' && !session()->has('videos-id')) {
        $this->redirectRoute('programs', navigate: true);
    }

    if ($this->path == 'video-player' && session()->has('video-player-id')) {
        $this->id = session()->get('video-player-id');
    }
    if ($this->path == 'video-player' && !session()->has('video-player-id')) {
        $this->redirectRoute('programs', navigate: true);
    }
});

?>

<div x-data="{showSidebar:false}" class="lg:flex lg:justify-between relative bg-[#b5c1c9]">
    <div class="w-3/12 p-6 max-lg:hidden"><livewire:logged-in-side-bar :path="$path"></div>
    <div :class="showSidebar ? 'translate-x-0' : '-translate-x-64'" class="w-64 py-6 px-4 transition-transform duration-200 absolute lg:hidden"><livewire:logged-in-side-bar :path="$path"></div>
    <div class="lg:w-9/12 w-full py-6 px-4 lg:px-8 grid grid-cols-1 gap-8 h-min">
        <div class="flex justify-center">
            <div class="py-8 px-8 items-center w-full flex justify-between rounded-2xl bg-[#d6dcde] text-3xl text-center text-[#f6aa23] font-bold">
                <div class="w-min lg:hidden"></div>
                <div class="w-full text-[#131e30] capitalize">{{str_replace("-"," ",$path)}}</div>
                <div @click="showSidebar=!showSidebar" class="w-min border border-[#131e30] text-[#131e30] p-1 lg:hidden rounded-lg">
                    <svg x-show="!showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                    <svg x-show="showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </div>
            </div>

        </div>
        <div>
            @if($path == 'dashboard')
            <livewire:dashboard lazy>
                @elseif($path == 'live-chat')
                <livewire:live-chat lazy>
                    @elseif($path == 'find-jobs')
                    <livewire:find-jobs lazy>
                        @elseif($path == 'programs')
                        <livewire:programs lazy>
                            @elseif($path == 'videos')
                            <livewire:videos :id="$id" lazy>
                                @elseif($path == 'video-player')
                                <livewire:video-player :id="$id">
                                    @elseif($path == 'admin-panel-video-player')
                                    <livewire:admin-panel.admin-panel-video-player :id="$id">
                                        @elseif($path == 'admin-panel')
                                        <livewire:admin-panel.admin-panel lazy>
                                            @elseif($path == 'admin-panel-users')
                                            <livewire:admin-panel.admin-panel-users lazy>
                                                @elseif($path == 'admin-panel-programs')
                                                <livewire:admin-panel.admin-panel-programs lazy>
                                                    @elseif($path == 'admin-panel-videos')
                                                    <livewire:admin-panel.admin-panel-videos :id="$id" lazy>
                                                        @endif
        </div>
    </div>
    <livewire:modals.modal-list>
</div>