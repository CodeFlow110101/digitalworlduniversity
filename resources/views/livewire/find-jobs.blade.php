<?php

use function Livewire\Volt\{with, on, placeholder, state, usesPagination};
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

usesPagination();

state(['is_seller_mode' => false]);



with(fn() => ['jobs' => Job::when($this->is_seller_mode, function ($query) {
    return $query->where('created_by', Auth::user()->id);
})->paginate(0)]);

on(['reset-find-jobs-page' => function () {
    $this->resetPage();
}]);

$deleteJob = function ($id) {
    $job = Job::find($id);
    Job::where('id', $id)->delete();
    Storage::disk('public')->delete($job->image);
};

?>

<div>
    <div class="fixed z-10 bottom-12 right-12 flex justify-between gap-4">
        @if($is_seller_mode)
        <div>
            <button wire:click="$dispatch('show-modal', { modal:'add-job', args:null, data:null, callback_event:null })" class=" bg-[#d6dcde] dark:bg-gray-800 text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
                <div>
                    <svg class="w-6 h-6 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="text-[#131e30] dark:text-[#DDE6ED] font-semibold">
                    Add Job
                </div>
            </button>
        </div>
        @endif
        <div>
            <button wire:click="$toggle('is_seller_mode')" class="bg-[#d6dcde] dark:bg-gray-800 text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
                <div class="text-[#131e30] dark:text-[#DDE6ED] font-semibold">
                    {{$is_seller_mode?'Seller':'Buyer'}} Mode
                </div>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($jobs as $job)
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$job->image)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] dark:text-[#DDE6ED] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$job->title}}</div>
                <div class="font-semibold text-md capitalize">{{$job->description}}</div>
            </div>
            @if($is_seller_mode)
            <div wire:click="deleteJob({{$job->id}})" class="text-[#d6dcde] bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold cursor-pointer">Delete</div>
            @else
            <a href="{{$job->url}}" target="_blank" class="text-[#d6dcde] bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold">Apply</a>
            @endif
        </div>
        @endforeach
    </div>
</div>