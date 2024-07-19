<?php

use App\Models\Job;
use App\Models\LkUserPlan;
use App\Models\ReferralCode;
use App\Models\ReferralIncome;
use App\Models\User;
use App\Models\VideoProgress;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{state, with, on, placeholder, usesPagination};

usesPagination();

with(fn() => ['users' => User::where('id', '!=', Auth::user()->id)->paginate(0)]);

placeholder('<div class="w-full h-96 mt-10 flex justify-center items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-white animate-spin fill-[#131e30]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
            </div>');

on([
    'reset-admin-panel-users' => function () {
        $this->resetPage();
    }
]);

$deleteUser = function ($id) {

    User::where('id', $id)->delete();

    LkUserPlan::where('user_id', $id)->delete();

    ReferralCode::where('user_id', $id)->delete();

    ReferralIncome::where('user_id', $id)->delete();

    Wallet::where('user_id', $id)->delete();

    VideoProgress::where('user_id', $id)->delete();

    $jobs = Job::where('created_by', $id)->get();

    foreach ($jobs as $job) {
        Storage::disk('public')->delete($job->image);
    }

    Job::where('created_by', $id)->delete();
};

?>

<div class="text-[#131e30] bg-[#d6dcde] rounded-2xl p-6">
    <button wire:click="$dispatch('show-modal', { modal:'modal-user', args:null, data:null, callback_event:null })" class="fixed z-10 bottom-12 right-12 hover:bg-gray-300 bg-[#d6dcde] text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
        <div>
            <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="text-[#131e30] font-semibold">
            Add User
        </div>
    </button>
    <table class="w-full text-xl sm:text-lg">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr wire:key="user-{{$user->id}}" class="text-center text-xl sm:text-md font-semibold">
                <td class="py-4">{{$user->name}}</td>
                <td class="py-4">{{$user->email}}</td>
                <td x-data="{showDropdown:false}" @click.away="showDropdown=false" class="flex justify-center py-4 relative">
                    <div @click="showDropdown=!showDropdown" class="rounded-full p-2 hover:bg-gray-400 cursor-pointer">
                        <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01" />
                        </svg>
                    </div>
                    <div :class="showDropdown?'sclae-y-100':'scale-y-0'" class="absolute text-md transition-transform duration-100 rounded-xl grid grid-cols-1 gap-2 w-3/4 p-2 z-10 origin-top top-16 bg-gray-400">
                        <div wire:click="deleteUser({{$user->id}})" class="cursor-pointer">Delete</div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>