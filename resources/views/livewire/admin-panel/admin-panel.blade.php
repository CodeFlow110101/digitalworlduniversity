<?php

use App\Models\Channel;
use App\Models\EarnMoney;
use App\Models\Job;
use App\Models\Program;
use App\Models\Store;
use App\Models\User;

use function Livewire\Volt\{state, mount, placeholder};

state(['users', 'programs', 'store', 'earnmoney', 'jobs', 'channels']);



$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};

mount(function () {
    $this->users = User::count();
    $this->programs = Program::count();
    $this->store = Store::count();
    $this->earnmoney = EarnMoney::count();
    $this->jobs = Job::where('is_approved', false)->count();
    $this->channels = Channel::count();
});


?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        <div wire:click="redirectTo('admin-panel-users')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] dark:text-[#DDE6ED] text-5xl">{{$users}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-programs')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$programs}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-store')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$store}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-earn-money')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$earnmoney}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-find-jobs')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$jobs}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-channel')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$channels}}</div>
                </div>
            </div>
        </div>
        <div wire:click="redirectTo('admin-panel-withdrawal')" class="bg-[#d6dcde] dark:bg-gray-800 cursor-pointer rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 rounded-t-2xl ">
                <div class="w-min flex justify-between gap-5">
                    <div>
                        <svg class="w-14 h-14 text-[#131e30] dark:text-[#DDE6ED]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </div>
                    <div class="text-[#131e30] text-5xl dark:text-[#DDE6ED]">{{$channels}}</div>
                </div>
            </div>
        </div>
    </div>
</div>