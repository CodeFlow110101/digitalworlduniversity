<?php

use function Livewire\Volt\{state, layout, mount, on, updated};

use App\Models\Program;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

layout('components.layouts.app');

state(['path', 'id', 'url', 'user', 'data', 'darkmode']);

on([
    'reset-user-landing-page' => function () {
        $this->user = Auth::user();
    }
]);

updated(['darkmode' => function () {
    User::where('id', $this->user->id)->update(['dark_mode' => $this->darkmode]);

    if ($this->darkmode) {
        $this->js("document.documentElement.classList.add('dark');");
    } else {
        $this->js("document.documentElement.classList.remove('dark');");
    }
}]);

mount(function (Request $request) {

    if (!Auth::check()) {
        return $this->redirectRoute('landing-page', navigate: true);
    }

    $this->path = $request->path();
    $this->url = $request->url();
    $this->darkmode = Auth::user()->dark_mode;

    if ($this->darkmode) {
        $this->js("document.documentElement.classList.add('dark');");
    } else {
        $this->js("document.documentElement.classList.remove('dark');");
    }

    if (Gate::check('is_Student') && str_contains($this->path, 'admin-panel')) {
        $this->redirectRoute('dashboard', navigate: true);
    }

    if (Gate::check('is_subscription_Expired') && in_array($this->path, ['live-chat', 'find-jobs', 'programs', 'videos', 'video-player', 'store', 'earn-money'])) {
        $this->redirectRoute('dashboard', navigate: true);
    }

    $this->user = Auth::user();

    if ($this->path == 'admin-panel-videos' && session()->has('admin-panel-video-id')) {
        $this->id = session()->get('admin-panel-video-id');
    }
    if ($this->path == 'admin-panel-videos' && !session()->has('admin-panel-video-id')) {
        $this->redirectRoute('admin-panel-programs', navigate: true);
    }

    if ($this->path == 'admin-panel-video-player' && session()->has('admin-panel-video-player-id')) {
        $this->data = session()->get('admin-panel-video-player-id');
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
        $this->data = session()->get('video-player-id');
    }
    if ($this->path == 'video-player' && !session()->has('video-player-id')) {
        $this->redirectRoute('programs', navigate: true);
    }

    if ($this->path == 'admin-panel-group' && !session()->has('admin-panel-channel-id')) {
        $this->redirectRoute('admin-panel', navigate: true);
    }

    if ($this->path == 'admin-panel-group' && session()->has('admin-panel-channel-id')) {
        $this->id = session()->get('admin-panel-channel-id');
    }
});

?>

<div x-data="{showSidebar:false}" class="lg:flex lg:justify-between relative bg-[#b5c1c9] dark:bg-black select-none">
    <livewire:style.logged-in-landing-page-style>
        <div class="w-3/12 p-6 max-lg:hidden"><livewire:logged-in-side-bar :path="$path" :user="$user"></div>
        <div :class="showSidebar ? 'translate-x-0' : '-translate-x-64'" class="w-64 py-6 px-4 transition-transform duration-200 absolute lg:hidden z-50"><livewire:logged-in-side-bar :path="$path" :user="$user"></div>
        <div class="lg:w-9/12 w-full py-6 px-4 lg:px-8 grid grid-cols-1 gap-8 h-min">
            <div class="flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input wire:click="$toggle('darkmode')" wire:model="darkmode" type="checkbox" value="{{$darkmode}}" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200  peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Dark Mode</span>
                </label>
            </div>
            <div class="flex justify-center">
                <div class="py-8 px-4 lg:px-8 items-center w-full flex justify-between rounded-2xl bg-[#d6dcde] dark:bg-gray-800 text-3xl text-center font-bold">
                    <div class="w-full text-[#131e30] dark:text-[#DDE6ED] capitalize">@if($path == 'video-player' || $path == 'admin-panel-video-player') {{Program::find(Video::find($this->data['video-player-id'])->program_id)->title}} @else {{str_replace("-"," ",$path)}} @endif</div>
                    <div @click="showSidebar=!showSidebar" class="w-min border border-[#131e30] dark:border-[#DDE6ED] text-[#131e30] p-1 lg:hidden rounded-lg">
                        <svg x-show="!showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                        <svg x-show="showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                @if($path == 'dashboard')
                <livewire:dashboard :url="$url" lazy />
                @elseif($path == 'live-chat')
                <livewire:live-chat lazy />
                @elseif($path == 'find-jobs')
                <livewire:find-jobs lazy />
                @elseif($path == 'programs')
                <livewire:programs lazy />
                @elseif($path == 'videos')
                <livewire:videos :id="$id" lazy />
                @elseif($path == 'video-player')
                <livewire:video-player :data="$data" />
                @elseif($path == 'store')
                <livewire:store lazy />
                @elseif($path == 'earn-money')
                <livewire:earn-money lazy />
                @elseif($path == 'settings')
                <livewire:settings :user="$user" lazy />
                @elseif($path == 'admin-panel-video-player')
                <livewire:admin-panel.admin-panel-video-player :data="$data" />
                @elseif($path == 'admin-panel')
                <livewire:admin-panel.admin-panel lazy />
                @elseif($path == 'admin-panel-find-jobs')
                <livewire:admin-panel.admin-panel-find-jobs lazy />
                @elseif($path == 'admin-panel-users')
                <livewire:admin-panel.admin-panel-users lazy />
                @elseif($path == 'admin-panel-programs')
                <livewire:admin-panel.admin-panel-programs lazy />
                @elseif($path == 'admin-panel-store')
                <livewire:admin-panel.admin-panel-store lazy />
                @elseif($path == 'admin-panel-earn-money')
                <livewire:admin-panel.admin-panel-earn-money lazy />
                @elseif($path == 'admin-panel-channel')
                <livewire:admin-panel.admin-panel-channel lazy />
                @elseif($path == 'admin-panel-group')
                <livewire:admin-panel.admin-panel-group :id="$id" lazy />
                @elseif($path == 'admin-panel-videos')
                <livewire:admin-panel.admin-panel-videos :id="$id" lazy />
                @endif
            </div>
        </div>
        <livewire:modals.modal-list />
</div>