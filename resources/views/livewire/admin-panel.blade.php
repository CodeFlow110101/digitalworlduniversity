<?php

use App\Models\User;

use function Livewire\Volt\{state, mount};

state(['users', 'programs']);

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

mount(function () {
    $this->users = User::count();
    $this->programs = 0;
});


?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        <div wire:click="redirectTo('admin-panel-users')" class="bg-[#d6dcde] cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl">{{$users}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-programs')" class="bg-[#d6dcde] cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl">{{$programs}}</div>
                </div>
            </div>
        </div>
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl">{{$programs}}</div>
                </div>
            </div>
        </div>
    </div>
</div>