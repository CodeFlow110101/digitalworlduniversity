<?php

use App\Models\LkUserPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{mount, state, on};

state(['balance', 'days_remaining', 'expiry_date',]);

state(['user'])->reactive();

on(['settings-handle-file' => function ($validationKey, $validationMessage, $thumbnailName, $thumbnailPath) {

    if ($validationKey && $validationKey['thumbnail']) {

        if ($validationKey['thumbnail']) {
            $this->addError('thumbnail', $validationMessage['thumbnail']);
        }

        $this->dispatch('admin-panel-modal-store-loader', value: false);
    } else {
        if ($this->user->image) {
            Storage::disk('public')->delete($this->user->image);
        }
        User::where('id', $this->user->id)->update(['image' => $thumbnailPath]);
        $this->dispatch('reset-user-landing-page');
    }
}]);

$removePhoto = function () {
    if ($this->user->image) {
        Storage::disk('public')->delete($this->user->image);
    }
    User::where('id', $this->user->id)->update(['image' => null]);
    $this->dispatch('reset-user-landing-page');
};

mount(function ($user) {
    $this->$user = $user;
    $this->expiry_date = LkUserPlan::where('user_id', $this->user->id)->first()->expiry_date;
    $this->days_remaining = (int)Carbon::now()->diffInDays($this->expiry_date);
});

?>

<div>
    <div class="fixed z-10 bottom-12 right-12 flex justify-between gap-4">
        <button wire:click="$dispatch('show-modal', { modal:'modal-update-user', args:null, data:null, callback_event:null })" class="bg-[#d6dcde] dark:bg-gray-800 text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
            <div>
                <svg class="w-6 h-6 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="text-[#131e30] dark:text-[#DDE6ED] font-semibold">
                Update Details
            </div>
        </button>
        <button wire:click="$dispatch('show-modal', { modal:'modal-reset-password', args:null, data:null, callback_event:null })" class="bg-[#d6dcde] dark:bg-gray-800 text-xl flex justify-between items-center gap-4 rounded-lg py-2 px-4">
            <div>
                <svg class="w-6 h-6 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="text-[#131e30] dark:text-[#DDE6ED] font-semibold">
                Update Password
            </div>
        </button>
    </div>

    <div class="text-[#131e30] dark:text-[#DDE6ED] grid grid-cols-1 gap-6 sm:gap-10 text-xl lg:text-3xl">
        <div class="flex justify-center items-center">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex justify-center">
                    @if($user->image)
                    <img src="{{asset('storage/'.$user->image)}}" class="w-24 h-24 lg:w-28 lg:h-28 rounded-full">
                    @else
                    <svg class="w-24 h-24 lg:w-28 lg:h-28 text-[#131e30] dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                            clip-rule="evenodd" />
                    </svg>
                    @endif
                </div>
                <div class="flex justify-center">
                    <div class="flex justify-between gap-3 font-semibold">
                        <div wire:click="removePhoto" class="bg-[#131e30] dark:bg-gray-800 px-8 py-4 text-lg font-semibold rounded-lg text-[#d6dcde] cursor-pointer">Remove</div>
                        <div @click="$refs.photo.click()" class="bg-[#131e30] dark:bg-gray-800 px-8 py-4 text-lg font-semibold rounded-lg text-[#d6dcde] cursor-pointer">Edit</div>
                        <input wire:input="$dispatch('upload-thumbnail', { thumbnail: $refs.photo, thumbnailSizeLimit:1, callbackDispatch:'settings-handle-file', callbackLoaderDispatch:'settings-loader'})" x-ref="photo" type="file" accept="image/*" class="block hidden px-2.5 pb-2.5 pt-4 w-full text-sm text-[#131e30] bg-transparent rounded-lg border-2 border-[#131e30] appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-16 text-center font-bold text-xl lg:text-2xl">
            <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl py-8 lg:py-12">Student ID: {{$user->id}}</div>
            <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl py-8 lg:py-12">{{$days_remaining}} Days</div>
            <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl py-8 lg:py-12">Total Income: ${{$user->referral_income + $user->task_income}}</div>
        </div>
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl py-12 px-2 text-center font-bold">Name: {{$user->name}}</div>
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl py-12 px-2 text-center font-bold select-text">Email: {{$user->email}}</div>
    </div>
</div>