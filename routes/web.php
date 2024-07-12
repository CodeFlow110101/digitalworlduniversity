<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Volt::route('/', 'main-landing-page')->name('landing-page');
Volt::route('/sign-up', 'main-landing-page')->name('sign-up');
Volt::route('/log-in', 'main-landing-page')->name('log-in');

Volt::route('/dashboard', 'logged-in-landing-page')->name('dashboard');
Volt::route('/live-chat', 'logged-in-landing-page')->name('live-chat');
