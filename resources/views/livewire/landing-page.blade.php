<?php

use App\Models\Program;
use App\Models\Video;
use function Livewire\Volt\{with};

with(fn() => ['programs' => Program::get()]);

$redirectTo = function ($path) {
    $this->redirectRoute($path, navigate: true);
};
?>

<div>
    <div class="flex jusity-center w-full mt-16">
        <div class="w-full grid grid-cols-1 gap-5 max-sm:px-4">
            <div class="lg:text-6xl sm:text-4xl text-xl text-white font-semibold flex justify-center w-full">
                <div class="w-min uppercase whitespace-nowrap flex justify-between gap-3">
                    <div class="font-light">Money making is</div>
                    <div class="font-bold">a skill hello</div>
                </div>
            </div>
            <div class="lg:text-3xl sm:text-xl text-lg text-white font-semibold flex justify-center w-full">
                <div class="w-min  whitespace-nowrap flex justify-between gap-3">
                    <div class="font-medium">We will teach you how to</div>
                    <div class="font-bold">master it</div>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="border border-gray-300 bg-gray-800 rounded-lg p-2 lg:w-3/5 w-11/12">
                    <video class="w-full h-full rounded-lg" controls autoplay muted loop>
                        <source src="{{asset('videos/IMG_5884.mp4')}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="flex justify-center pt-8">
                <div wire:click="redirectTo('sign-up')"
                    class="py-4 px-8 font-extrabold lg:tracking-wider lg:text-xl text-sm w-min whitespace-nowrap bg-[#f6aa23] rounded-lg uppercase hover:scale-105 transition-transform duration-200">
                    join Digital Worlds University</div>
            </div>
            <div class="flex justify-center">
                <div class="text-gray-400 lg:text-base text-sm">Join 113,000+ like-minded students</div>
            </div>
            <div class="flex justify-center">
                <div class="text-gray-400 uppercase tracking-widest lg:text-2xl text-base">Introducing</div>
            </div>
            <div class="flex justify-center">
                <div class="text-white uppercase lg:text-5xl sm:text-2xl text-lg">A massive upgrade</div>
            </div>
            <div class="flex justify-center text-center">
                <div class="text-gray-400 lg:text-2xl sm:text-lg text-base">The modern education system is designed to make
                    you poor
                </div>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1 gap-1">
                    <div class="flex justify-center">
                        <div class="text-white w-full lg:text-2xl text-sm text-pretty text-center gap-1">
                            <div class="font-bold">Imagine you could get access to multi-millionaire mentors who will give you</div>
                        </div>
                    </div>
                    <div class="text-gray-400 lg:text-2xl text-sm text-center">step-by-step path to reach your goals as fast as possible…</div>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1 gap-1">
                    <div class="text-white lg:text-2xl text-sm text-center text-pretty">
                        <span>That's</span>
                        <span class="font-bold">exactly
                        </span>
                        <span>what you can find</span>
                        <span class="font-bold">inside digital worlds university</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-12 sm:py-32 py-16 bg-slate-900 sm:px-12 px-4 grid cols-1 gap-12">
        <div x-ref="scrollFeatures" x-on:scroll-features.window="$refs.scrollFeatures.scrollIntoView({ behavior: 'smooth' });"></div>
        <div class="flex justify-between sm:gap-8">
            <div class="h-full xl:hidden">
                <div class="w-min h-full xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>
            </div>
            <div class="xl:flex xl:justify-between w-full gap-14">
                <div role="status"
                    class="flex lg:mt-24 mb-24 mt-8 items-center justify-center h-56 w-full bg-gray-600 rounded-lg">
                    <svg class="w-10 h-10 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                        <path
                            d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z" />
                    </svg>
                </div>

                <div class="w-min h-auto max-xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="md:text-4xl text-2xl text-white uppercase text-center font-thin">Learn Vital <span
                            class="font-extrabold">Life
                            Lessons</span>
                    </div>
                    <div class="grid grid-cols-1 gap-8 mt-12 text-white">
                        <div class="flex justify-between max-w-max gap-4 items-center">
                            <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 11.917 9.724 16.5 19 7.5" />
                            </svg>
                            <div class="md:text-2xl text-lg text-gray-300">World-class <span class="text-white font-bold">custom
                                    built
                                    learning
                                    application</span>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300">Scale from <span class="text-white font-bold">Zero
                                        to
                                        $10k/month</span>
                                    as fast as possible
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300">Master the skills you need to <span
                                        class="text-white font-bold">
                                        maximise your income</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between sm:gap-8">
            <div class="h-full xl:hidden">
                <div class="w-min h-full xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>
            </div>
            <div class="xl:flex xl:justify-between w-full gap-14">
                <div role="status"
                    class="flex lg:mt-24 mb-24 mt-8 items-center justify-center h-56 w-full bg-gray-600 rounded-lg ">
                    <svg class="w-10 h-10 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                        <path
                            d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z" />
                    </svg>
                </div>

                <div class="w-min h-auto max-xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="md:text-4xl text-2xl text-white uppercase text-center font-thin">Join a private <span
                            class="font-extrabold">network</span>
                    </div>
                    <div class="grid grid-cols-1 gap-8 mt-12 text-white">
                        <div class="flex justify-between max-w-max gap-4 items-center">
                            <div class="flex justify-between gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300"><span class="text-white font-bold">Celebrate your
                                        wins</span> with people who <div>understand</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300">Make <span class="text-white font-bold">like-minded
                                        friends</span>
                                    on your journey
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300"><span class="text-white font-bold">
                                        Network with 113,000+ people</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between sm:gap-8">
            <div class="h-full xl:hidden">
                <div class="w-min h-full xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>
            </div>
            <div class="xl:flex xl:justify-between w-full gap-14">
                <div role="status"
                    class="flex lg:mt-24 mb-24 mt-8 items-center justify-center h-56 w-full bg-gray-600 rounded-lg ">
                    <svg class="w-10 h-10 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                        <path
                            d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z" />
                    </svg>
                </div>

                <div class="w-min h-auto max-xl:hidden">
                    <div class="h-4 w-4 rounded-full bg-gray-100"></div>
                    <div class="my-2 flex h-full justify-center">
                        <div class="h-auto w-0.5 bg-gray-800 rounded"></div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="md:text-4xl text-2xl text-white uppercase text-center font-thin">Access to <span
                            class="font-extrabold">multimillionaire</span>
                    </div>
                    <div class="grid grid-cols-1 gap-8 mt-12 text-white">
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300"><span class="text-white font-bold">Mentors are
                                    </span> hyper-successful experts in their <div> field</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300">Get <span class="text-white font-bold">mentored
                                        every step</span>
                                    of your journey
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between gap-4 items-center">
                            <div class="flex justify-between max-w-max gap-4 items-center">
                                <svg class="md:w-12 md:h-12 w-8 h-8 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                <div class="md:text-2xl text-lg text-gray-300"><span class="text-white font-bold">
                                        1-on-1 advice</span>from industry experts
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-14">
            <div class="flex justify-center pt-8">
                <div wire:click="redirectTo('sign-up')"
                    class="py-4 px-8 font-extrabold lg:tracking-wider lg:text-xl text-sm w-min whitespace-nowrap bg-[#f6aa23] rounded-lg uppercase hover:scale-105 transition-transform duration-200">
                    join Digital Worlds University</div>
            </div>
            <div class="flex justify-center">
                <div class="text-gray-400">Join 113,000+ like-minded students</div>
            </div>
        </div>

        <!-- Programs -->

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-12">
            @foreach($programs as $program)
            <div class="grid grid-cols-1 gap-6 sm:gap-12 text-white bg-gray-700 rounded-2xl pt-10 sm:pt-16">
                <div class="text-2xl sm:text-4xl font-bold flex justify-center">
                    <div class="flex justify-between gap-4 w-min whitespace-nowrap items-center">
                        <div>
                            <svg class="w-10 h-10 sm:w-16 sm:h-16 text-[#f6aa23]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>{{$program->title}}</div>
                    </div>
                </div>
                <div class="text-xl sm:text-2xl font-light text-center text-gray-300 px-12">
                    {{substr($program->description, 0, 100)}}
                    @if(strlen($program->description) > 100)<span>...</span>@endif
                </div>
                <div class="flex justify-center items-center">
                    <div wire:click="$dispatch('show-modal', { modal:'modal-landing-page-program-preview', args:{{$program->id}}, data:null, callback_event:null })" class="w-min py-2 px-6 whitespace-nowrap cursor-pointer tracking-wider border border-[#f6aa23] rounded-lg text-[#f6aa23] hover:text-[#050e14] transition-colors duration-500 hover:bg-[#f6aa23] font-semibold text-lg sm:text-2xl">Learn More</div>
                </div>
                <div>
                    @if(Video::where('program_id',$program->id)->count()!=0)
                    @php
                    $url = Video::where('program_id',$program->id)->first()->video;
                    @endphp
                    <video x-ref=" myVideo" class="h-96 w-full rounded-b-2xl bg-black" controls controlsList="nodownload">
                        <source src="{{asset('storage/'.$url)}}" type="video/mp4">
                        <source src="{{asset('storage/'.$url)}}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Testinomials -->
    <div x-ref="scrollReview" x-on:scroll-review.window="$refs.scrollReview.scrollIntoView({ behavior: 'smooth' });"></div>
    <div class="grid grid-cols-1 gap-16 py-20">
        <div class="grid grid-cols-1 gap-4">
            <div class="uppercase sm:text-xl md:text-2xl font-semibold tracking-widest text-gray-500 text-center">the real world wins</div>
            <div class="text-white uppercase text-3xl md:text-5xl tracking-wider text-center">our students are winning</div>
        </div>

        <div class="flex justify-center px-2 md:px-12 lg:px-20">
            <div class="grid grid-cols-4 gap-2 md:gap-6 lg:gap-6 w-full">
                @for($i=1;$i<=4;$i++)
                    <div class="flex items-center justify-center w-full h-36 sm:h-80 bg-gray-800 rounded-lg">
                    <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                    </svg>
            </div>
            @endfor
        </div>
    </div>
</div>

<!-- Section -->

<div x-ref="scrollDoubt" x-on:scroll-doubt.window="$refs.scrollDoubt.scrollIntoView({ behavior: 'smooth' });"></div>
<div class="flex justify-center py-20">
    <div class="grid grid-cols-1 gap-8 sm:gap-12 w-3/4 text-white text-center">
        <div class="text-2xl sm:text-3xl lg:text-4xl font-semibold">WILL YOU LISTEN?</div>
        <div class="sm:text-lg md:text-xl lg:text-2xl text-thin"><span class="font-bold">Earning money is a skill, just like any other skill -it can be acquired,</span> and the pace of learning is influenced by your coaches and the learning environment provided.</div>
        <div class="sm:text-lg md:text-xl lg:text-2xl text-thin">Our coaches are hyper-successful in the business models they teach, understand the keys to profitability, and are quick to embrace and leverage new disruptive technologies and strategies.</div>
        <div class="sm:text-lg md:text-xl lg:text-2xl text-thin"><span class="font-bold">Enter THE REAL WORLD, the comprehensive learning platform</span> that takes you from earning your first dollar online to scaling up into a 7- figure enterprise.</div>
        <div class="sm:text-lg md:text-xl lg:text-2xl text-thin"><span class="font-bold">There's no better place on the planet to acquire the knowledge and skills needed to make money online</span> in today's changing world.</div>
        <div class="text-2xl sm:text-3xl lg:text-4xl font-semibold">YOU HAVE A CHOICE TO MAKE</div>
    </div>
</div>

<!-- Footer -->
<div class="sm:pt-20 pt-8 pb-14 grid grid-cols-1 gap-12 bg-slate-900">
    <div class="grid grid-cols-1 gap-4 text-white text-center">
        <div wire:click="redirectTo('terms-and-conditions')" class="sm:text-xl text-base underline hover:text-[#f6aa23] cursor-pointer">Terms & Conditions</div>
        <div class="sm:text-xl text-base underline hover:text-[#f6aa23] cursor-pointer">Privacy Policy</div>
        <div class="sm:text-lg text-sm font-bold">Support: support@digitalworldsuniversity.com</div>
    </div>
    <div class="flex justify-center">
        <div class="w-4/5 grid grid-cols-1 gap-4">
            <div class="text-gray-400 sm:text-xl text-sm font-normal text-center">Everything taught within The Real World is for education purposes only. It is up to each student to implement and do the work.</div>
            <div class="text-gray-400 sm:text-xl text-sm font-normal text-center">The Real World team doesn’t guarantee any profits or financial success.</div>
        </div>
    </div>
</div>
</div>