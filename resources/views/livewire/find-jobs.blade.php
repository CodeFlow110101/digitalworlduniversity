<?php

use function Livewire\Volt\{with, on, placeholder, state, usesPagination};
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

usesPagination();

state(['is_seller_mode' => false]);

placeholder('<div class="w-full h-96 mt-10 flex justify-center items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-white animate-spin fill-[#131e30]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>');

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
            <button wire:click="$dispatch('show-modal', { modal:'add-job', args:null, data:null, callback_event:null })" class=" hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
                <div>
                    <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="text-[#131e30] font-semibold">
                    Add Job
                </div>
            </button>
        </div>
        @endif
        <div>
            <button wire:click="$toggle('is_seller_mode')" class=" hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
                <div class="text-[#131e30] font-semibold">
                    {{$is_seller_mode?'Seller':'Buyer'}} Mode
                </div>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($jobs as $job)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$job->image)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$job->title}}</div>
                <div class="font-semibold text-md capitalize">{{$job->description}}</div>
            </div>
            @if($is_seller_mode)
            <div wire:click="deleteJob({{$job->id}})" class="text-[#d6dcde] bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold">Delete</div>
            @else
            <a href="{{$job->url}}" target="_blank" class="text-[#d6dcde] bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold">Apply</a>
            @endif
        </div>
        @endforeach
    </div>
</div>