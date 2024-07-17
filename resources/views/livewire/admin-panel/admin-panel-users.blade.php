<?php

use App\Models\User;
use function Livewire\Volt\{state, with, on};

with(['users' => User::paginate(0)]);

on([
    'reset-admin-panel-users' => function () {
        $this->reset();
    }
]);
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
                <td class="flex justify-center py-4">
                    <svg class="w-6 h-6 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                    </svg>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>