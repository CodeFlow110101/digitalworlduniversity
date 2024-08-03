<?php

use function Livewire\Volt\{with, on, placeholder, state, usesPagination};
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

usesPagination();

state(['is_seller_mode' => false]);

with(fn() => ['jobs' => Job::where('is_approved', false)->paginate(0)]);

on(['reset-find-jobs-page' => function () {
    $this->resetPage();
}]);

$deleteJob = function ($id) {
    $job = Job::find($id);
    Job::where('id', $id)->delete();
    Storage::disk('public')->delete($job->image);
};

$approveJob = function ($id) {
    Job::where('id', $id)->update(['is_approved' => true]);
};

?>

<div>
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
            <div class="flex justify-between items-center text-[#d6dcde] bg-[#131e30] py-4 rounded-b-xl">
                <div wire:click="deleteJob({{$job->id}})" class="text-center text-lg w-full font-bold cursor-pointer">Delete</div>
                <div class="w-0 h-full border border-[#d6dcde]"></div>
                <div wire:click="approveJob({{$job->id}})" class="text-center text-lg w-full font-bold cursor-pointer">Approve</div>
            </div>
        </div>
        @endforeach
    </div>
</div>