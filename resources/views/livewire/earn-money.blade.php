<?php

use App\Models\EarnMoney;
use Illuminate\Database\Eloquent\Builder;

use function Livewire\Volt\{state, placeholder, with, mount};

state(['user']);

with(fn() => ['surveys' => EarnMoney::with(['questions.responses'])->has('questions', 15)->get()]);

$isAttended = function ($survey) {
    return $survey->questions->filter(function ($question) use ($survey) {
        $hasResponses =  $question->responses->contains(function ($response) {
            return $response->user_id == $this->user->id;
        });
        return $hasResponses && $question->survey_id == $survey->id;
    })->isNotEmpty();
};

mount(function ($user) {
    $this->user = $user;
});
?>

<div class="grow relative" x-data="{ pageHeight: 0 , tabHeight: 0}" x-resize="pageHeight = $height">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 overflow-y-auto p-6 absolute inset-x-0" :style="'height: ' + pageHeight + 'px;'">
        @foreach($surveys as $survey)
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl flex flex-col bg-cover bg-top" :style="{ height: tabHeight + 'px' , backgroundImage: `url('{{ $survey->thumbnail_url }}')`}">
            <div class="text-white bg-black flex flex-col justify-evenly py-2 mt-auto text-center">
                <div class="text-base">{{$survey->title}}</div>
                <div class="text-xs capitalize">{{$survey->description}}</div>
            </div>
            <div class="bg-black rounded-b-2xl text-center py-2">
                @if($this->isAttended($survey))
                <div class="bg-white mx-auto w-min rounded-full px-4 whitespace-nowrap">
                    Completed
                </div>
                @else
                <a href="/earn-money-survey/{{$survey->id}}" wire:navigate class="bg-white mx-auto w-min rounded-full px-4 whitespace-nowrap">
                    Start Earning
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-white bg-white absolute inset-0 p-6 flex flex-col gap-6 opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>