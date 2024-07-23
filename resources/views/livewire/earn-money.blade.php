<?php

use App\Models\EarnMoney;

use function Livewire\Volt\{state, placeholder, usesPagination, with};

usesPagination();



with(fn() => ['items' => EarnMoney::paginate(0)]);

?>

<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($items as $item)
        <div class="bg-[#d6dcde] rounded-2xl grid grid-cols-1 gap-4">
            <div class="flex items-center justify-center w-full h-48 bg-gray-500 rounded-t-2xl">
                <img src="{{asset('storage/'.$item->thumbmail)}}" class="w-full h-full rounded-t-2xl">
            </div>
            <div class="p-4 text-[#131e30] grid grid-cols-1 gap-4">
                <div class="font-semibold text-2xl">{{$item->title}}</div>
                <div class="font-semibold text-md capitalize">{{$item->description}}</div>
            </div>
            <a href="{{$item->url}}" target="_blank" class="text-[#d6dcde] py-5 bg-[#131e30] rounded-b-2xl text-center py-3 text-lg font-bold">Follow Link</a>
        </div>
        @endforeach
    </div>
</div>