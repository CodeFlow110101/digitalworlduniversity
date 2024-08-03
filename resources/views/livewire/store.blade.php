<?php

use App\Models\Store;

use function Livewire\Volt\{state, placeholder, usesPagination, with};

usesPagination();

with(fn() => ['storeItems' => Store::paginate(0)]);

?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($storeItems as $items)
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$items->thumbmail)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] dark:text-[#DDE6ED] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$items->title}}</div>
                <div class="font-semibold text-md capitalize">{{$items->description}}</div>
            </div>
            <div class="text-[#d6dcde] py-5 bg-[#131e30] rounded-b-2xl text-center cursor-pointer text-lg font-bold">Buy ${{$items->price}}</div>
        </div>
        @endforeach
    </div>
</div>