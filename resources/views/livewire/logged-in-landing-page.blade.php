<?php

use function Livewire\Volt\{state, layout, mount, on, updated};

use App\Models\Program;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\FileUploads;
use Illuminate\Database\Eloquent\Builder;
use App\Models\EarnMoney;
use App\Models\EarnMoneyResponse;

layout('components.layouts.app');

state(['path', 'id', 'url', 'user', 'data']);

on([
    'reset-user-landing-page' => function () {
        $this->user = Auth::user();
    }
]);

$surveyNotAttended = function ($id) {
   return EarnMoneyResponse::where('user_id', $this->user->id)->whereHas('question', function (Builder $query) use ($id) {
        $query->where('survey_id', $id);
    })->doesntExist();
};

mount(function (Request $request) {

    if (!Auth::check()) {
        return $this->redirectRoute('landing-page', navigate: true);
    }

    $this->path = $request->path();
    $this->url = $request->url();

    if (Gate::check('is_Student') && str_contains($this->path, 'admin-panel')) {
        $this->redirectRoute('dashboard', navigate: true);
    }

    if (Gate::check('is_subscription_Expired') && in_array($this->path, ['live-chat', 'find-jobs', 'programs', 'video', 'video-player', 'store', 'earn-money'])) {
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

    if ($this->path == 'video' && session()->has('videos-id')) {
        $this->id = session()->get('videos-id');
    }

    if ($this->path == 'video' && !session()->has('videos-id')) {
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

    if (str_contains($this->path, 'admin-panel-earn-money-manage-question/') && EarnMoney::where('id', str_replace('admin-panel-earn-money-manage-question/', '', $this->path))->exists()) {
        $this->id = str_replace('admin-panel-earn-money-manage-question/', '', $this->path);
        $this->path = 'admin-panel-earn-money-manage-question';
    } elseif (str_contains($this->path, 'admin-panel-earn-money-manage-question/') && EarnMoney::where('id', str_replace('admin-panel-earn-money-manage-question/', '', $this->path))->doesntExist()) {
        $this->redirectRoute('admin-panel', navigate: true);
    }

    if (str_contains($this->path, 'earn-money-survey/') && EarnMoney::where('id', str_replace('earn-money-survey/', '', $this->path))->exists()) {
        if($this->surveyNotAttended(str_replace('earn-money-survey/', '', $this->path))){
            $this->id = str_replace('earn-money-survey/', '', $this->path);
            $this->path = 'earn-money-survey';
        }else{
        $this->redirectRoute('earn-money', navigate: true);

        }
    } elseif (str_contains($this->path, 'earn-money-survey/') && EarnMoney::where('id', str_replace('earn-money-survey/', '', $this->path))->doesntExist()) {
        $this->redirectRoute('admin-panel', navigate: true);
    }
});

?>

<div x-data="{showSidebar:false}" class="h-dvh flex flex-col">
    <div class="grow flex justify-between relative bg-white dark:bg-black select-none">
        <livewire:style.logged-in-landing-page-style />
        <div class="w-1/5">
            <livewire:side-bar :path="$path" :user="$user" />
        </div>
        <div class="lg:w-4/5 w-full flex flex-col gap-8">
            <div class="flex justify-center hidden">
                <div class="py-8 px-4 lg:px-8 items-center w-full flex justify-between rounded-2xl bg-white dark:bg-gray-800 text-3xl text-center font-bold">
                    <div class="w-full text-black dark:text-white capitalize">@if($path == 'video-player' || $path == 'admin-panel-video-player') {{Program::find(Video::find($this->data['video-player-id'])->program_id)->title}} @else {{str_replace("-"," ",$path)}} @endif</div>
                    <div @click="showSidebar=!showSidebar" class="w-min border border-black dark:border-white text-black p-1 lg:hidden rounded-lg">
                        <svg x-show="!showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                        <svg x-show="showSidebar" class="sm:w-8 sm:h-8 w-5 h-5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="grow flex flex-col">
                @if($path == 'dashboard')
                <livewire:dashboard :url="$url" />
                @elseif($path == 'live-chat')
                <livewire:chat />
                @elseif($path == 'find-jobs')
                <livewire:find-jobs />
                @elseif($path == 'programs')
                <livewire:programs />
                @elseif($path == 'video')
                <livewire:videos :id="$id" />
                @elseif($path == 'video-player')
                <livewire:video-player :data="$data" />
                @elseif($path == 'store')
                <livewire:store />
                @elseif($path == 'exam')
                <livewire:exam />
                @elseif($path == 'ai-tutor')
                <livewire:ai-tutor />
                @elseif($path == 'earn-money')
                <livewire:earn-money :user="$user" />
                @elseif($path == 'withdraw')
                <livewire:withdraw />
                @elseif($path == 'earn-money-survey')
                <livewire:earn-money-survey :id="$id" :user="$user" />
                @elseif($path == 'settings')
                <livewire:settings :user="$user" />
                @elseif($path == 'admin-panel-video-player')
                <livewire:admin-panel.admin-panel-video-player :data="$data" />
                @elseif($path == 'admin-panel')
                <livewire:admin-panel.admin-panel />
                @elseif($path == 'admin-panel-find-jobs')
                <livewire:admin-panel.admin-panel-find-jobs />
                @elseif($path == 'admin-panel-users')
                <livewire:admin-panel.admin-panel-users />
                @elseif($path == 'admin-panel-programs')
                <livewire:admin-panel.admin-panel-programs />
                @elseif($path == 'admin-panel-store')
                <livewire:admin-panel.admin-panel-store />
                @elseif($path == 'admin-panel-earn-money')
                <livewire:admin-panel.admin-panel-earn-money />
                @elseif($path == 'admin-panel-channel')
                <livewire:admin-panel.admin-panel-channel />
                @elseif($path == 'admin-panel-withdrawal')
                <livewire:admin-panel.admin-panel-withdrawal />
                @elseif($path == 'admin-panel-earn-money-manage-question')
                <livewire:admin-panel.admin-panel-earn-money-manage-question :id="$id" />
                @elseif($path == 'admin-panel-group')
                <livewire:admin-panel.admin-panel-group :id="$id" />
                @elseif($path == 'admin-panel-videos')
                <livewire:admin-panel.admin-panel-videos :id="$id" />
                @endif
            </div>
        </div>
        <livewire:modals.modal-list />
    </div>
</div>