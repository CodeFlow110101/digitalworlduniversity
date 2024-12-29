<?php

use App\Models\EarnMoney;
use App\Models\EarnMoneyQuestion;
use App\Models\EarnMoneyResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

use function Livewire\Volt\{state, mount, with, uses};

state(['id', 'responses' => [], 'total_questions', 'user', 'letters' => range('a', 'd')]);

uses([WithPagination::class, WithoutUrlPagination::class]);

with(
    fn() => ['questions' => EarnMoneyQuestion::whereHas('survey', function (Builder $query) {
        $query->where('id', $this->id);
    })->with(['options'])->simplePaginate(1)]
);

$updateResponse = function ($question, $option) {
    $this->responses[$question] = $option;
};

$submit = function () {
    $responses = [];
    foreach ($this->responses as $question_id => $option_id) {
        $responses[] = ['question_id' => $question_id, 'option_id' => $option_id];
    }
    $this->user->responses()->createMany($responses);
};

$test = function () {
    $surveys = EarnMoney::with(['questions.responses'])->get();

    foreach ($surveys as $survey) {
        $survey->questions->each(function ($question) {
            $question->responses->count();
        });
    }
};

mount(function ($id, $user) {
    $this->id = $id;
    $this->user = $user;
    $this->total_questions = EarnMoneyQuestion::whereHas('survey', function (Builder $query) {
        $query->where('id', $this->id);
    })->with(['options'])->count();
});
?>

<div class="grow bg-white flex flex-col">
    <div class="grow bg-black/50 flex flex-col gap-4 p-4">
        <div class="flex justify-end">
            <div class="bg-red-500 rounded-full text-white px-4 py-1">{{$questions->currentPage()}}/15 Questions</div>
        </div>
        @dump($this->responses)
        <div class="grow w-3/4 mx-auto flex flex-col gap-4 justify-center items-center bg-gradient-to-r from-white/50 to-white rounded-xl p-4">
            @foreach($questions as $question)
            <div class="w-full h-3/4 grow flex flex-col gap-4" :key="{{$question->id}}">
                <div class="flex flex-col text-center text-lg gap-2">
                    <div>Question 7</div>
                    <div>{{$question->text}}</div>
                </div>
                <div class="grow bg-gradient-to-r from-black/50 to-black/10 w-11/12 mx-auto rounded-xl flex justify-center items-center">
                    <div class="flex flex-col justify-evenly w-11/12 h-full text-white">
                        @foreach($question->options as $option)
                        <div class="flex justify-start items-center gap-2">
                            <input wire:input="updateResponse({{ $question->id }} , {{ $option->id }})" name="{{$question->id}}" id="{{$question->id}}" class="size-5" type="radio" @if(isset($responses[$question->id]) && $responses[$question->id] == $loop->iteration) checked @endif>
                            <div class="capitalize">{{$letters[$loop->iteration - 1]}}</div>
                            <div>{{$option->text}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            {{ $questions->links() }}
            @if(count($this->responses) == $total_questions)
            <button wire:click="submit" class="py-1 px-6 rounded-full bg-red-700 text-white border-8 border-red-500 shadow-inner">Submit</button>
            @endif
            <button wire:click="test" class="py-1 px-6 rounded-full bg-red-700 text-white border-8 border-red-500 shadow-inner">Submit</button>
        </div>
    </div>
</div>