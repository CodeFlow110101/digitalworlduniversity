<?php

use App\Models\EarnMoney;

use function Livewire\Volt\{state, mount, rules, with};

state(['question', 'options_1', 'options_2', 'options_3', 'options_4', 'correct_option', 'id', 'modal' => false]);

rules(['question' => 'required', 'options_1' => 'required', 'options_2' => 'required', 'options_3' => 'required', 'options_4' => 'required', 'correct_option' => 'required',]);

with(fn() => ['survey' => EarnMoney::with(['questions.options'])->find($this->id)]);

$submit = function () {

    $this->validate();

    $survey = EarnMoney::find($this->id);

    $question = $survey->questions()->create([
        'text' => $this->question
    ]);

    $question->options()->createMany([
        ['text' => $this->options_1, 'is_correct' => $this->correct_option == 1],
        ['text' => $this->options_2, 'is_correct' => $this->correct_option == 2],
        ['text' => $this->options_3, 'is_correct' => $this->correct_option == 3],
        ['text' => $this->options_4, 'is_correct' => $this->correct_option == 4],
    ]);

    $this->resetValidation();
    $this->reset(['question', 'options_1', 'options_2', 'options_3', 'options_4', 'correct_option', 'modal']);
};

$toggleModal = function () {
    $this->modal = !$this->modal;
    $this->resetValidation();
    $this->reset(['question', 'options_1', 'options_2', 'options_3', 'options_4', 'correct_option']);
};

mount(function ($id) {
    $this->id = $id;
});
?>

<div class="grow p-6 flex flex-col gap-2 dark:text-white">
    <div class="flex justify-between">
        <div>Total Questions: {{count($survey->questions)}}</div>
        @if(count($survey->questions) < 15)
        <button wire:click="toggleModal" class="border border-black dark:border-white rounded-md py-1 px-2">Add</button>
        @endif
    </div>
    <div class="grow relative" x-data="{ height: 0 }" x-resize="height = $height">
        <div class="absolute inset-0 overflow-y-auto flex flex-col gap-4" :style="'height: ' + height + 'px;'">
            @foreach($survey->questions as $question)
            <div class="border border-black dark:border-white rounded-md p-4 flex flex-col gap-2">
                <div>Question {{$loop->iteration}}: {{$question->text}}</div>
                <div class="flex flex-col gap-2">
                    @foreach($question->options as $option)
                    <div class="flex items-center gap-4">
                        @if($option->is_correct)
                        <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                        </svg>
                        @else
                        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        @endif
                        <div class="p-2 w-full">{{$option->text}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($modal)
    <div class="fixed inset-0 flex flex-col justify-center items-center border border-black dark:border-white">
        <form wire:submit="submit" class="w-1/2 bg-white dark:bg-black dark:border dark:border-white dark:rounded-lg shadow-md p-4">
            <div class="rounded-md p-4 flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <div>Question</div>
                    <div>
                        <button wire:click="toggleModal" type="button" class="hover:bg-black hover:dark:bg-white rounded-full p-1 group">
                            <svg class="w-5 h-5 text-black dark:text-white group-hover:text-white group-hover:dark:text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <input wire:model="question" class="border border-black dark:border-white p-2 w-full outline-none rounded-md bg-transparent">
                    @error('question')
                    <div class="text-sm text-red-700">{{$message}}</div>
                    @enderror
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <input wire:model="correct_option" type="radio" value=1>
                        <input wire:model="options_1" class="border border-black dark:border-white p-2 w-full outline-none rounded-md bg-transparent" placeholder="Option 1">
                    </div>
                    @error('options_1')
                    <div class="text-sm text-red-700">{{$message}}</div>
                    @enderror
                    <div class="flex items-center gap-4">
                        <input wire:model="correct_option" type="radio" value=2>
                        <input wire:model="options_2" class="border border-black dark:border-white p-2 w-full outline-none rounded-md bg-transparent" placeholder="Option 2">
                    </div>
                    @error('options_2')
                    <div class="text-sm text-red-700">{{$message}}</div>
                    @enderror
                    <div class="flex items-center gap-4">
                        <input wire:model="correct_option" type="radio" value=3>
                        <input wire:model="options_3" class="border border-black dark:border-white p-2 w-full outline-none rounded-md bg-transparent" placeholder="Option 3">
                    </div>
                    @error('options_3')
                    <div class="text-sm text-red-700">{{$message}}</div>
                    @enderror
                    <div class="flex items-center gap-4">
                        <input wire:model="correct_option" type="radio" value=4>
                        <input wire:model="options_4" class="border border-black dark:border-white p-2 w-full outline-none rounded-md bg-transparent" placeholder="Option 4">
                    </div>
                    @error('options_4')
                    <div class="text-sm text-red-700">{{$message}}</div>
                    @enderror
                </div>
                @error('correct_option')
                <div class="text-sm text-red-700">{{$message}}</div>
                @enderror
            </div>
            <div class="flex justify-center items-center">
                <button wire:loading.class="pointer-events-none" wire:target="submit" type="submit" class="bg-black dark:bg-white dark:text-black text-white rounded-md py-1 px-2 mx-auto">Submit</button>
            </div>
        </form>
    </div>
    @endif
</div>