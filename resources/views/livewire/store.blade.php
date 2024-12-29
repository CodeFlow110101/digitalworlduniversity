<?php

use App\Models\Store;

use function Livewire\Volt\{state, placeholder, with};

with(fn() => ['storeItems' => Store::get()]);

?>

<div class="grow relative" x-data="{ pageHeight: 0 , tabHeight: 0}" x-resize="pageHeight = $height">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 overflow-y-auto p-6 absolute inset-x-0" :style="'height: ' + pageHeight + 'px;'">
        @foreach($storeItems as $items)
        <div class="bg-[#d6dcde] dark:bg-gray-800 rounded-2xl flex flex-col bg-cover bg-top" :style="{ height: tabHeight + 'px' , backgroundImage: `url('{{ $items->thumbnail_url }}')`}">
            <div class="text-white bg-black flex flex-col justify-evenly py-2 mt-auto text-center">
                <div class="text-base">{{$items->title}}</div>
                <div class="text-xs capitalize">{{$items->description}}</div>
            </div>
            <div class="bg-black rounded-b-2xl text-center py-2">
                <a href="{{$items->link}}" target="_blank" class="bg-white mx-auto w-min rounded-full px-4 whitespace-nowrap">
                    Buy ${{$items->price}}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-white bg-white absolute inset-0 p-6 flex flex-col gap-6 opacity-0 pointer-events-none -z-50">
        <div class="bg-red-500 grow" x-resize="tabHeight = $height"></div>
        <div class="bg-red-500 grow"></div>
    </div>
</div>