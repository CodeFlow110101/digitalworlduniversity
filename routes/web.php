<?php

use App\Http\Controllers\FileUploads;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Volt::route('/', 'main-landing-page')->name('landing-page');
Volt::route('/sign-up', 'main-landing-page')->name('sign-up');
Volt::route('/log-in', 'main-landing-page')->name('log-in');

Volt::route('/dashboard', 'logged-in-landing-page')->name('dashboard');
Volt::route('/live-chat', 'logged-in-landing-page')->name('live-chat');
Volt::route('/find-jobs', 'logged-in-landing-page')->name('find-jobs');
Volt::route('/programs', 'logged-in-landing-page')->name('programs');
Volt::route('/videos', 'logged-in-landing-page')->name('videos');
Volt::route('/admin-panel', 'logged-in-landing-page')->name('admin-panel');
Volt::route('/admin-panel-users', 'logged-in-landing-page')->name('admin-panel-users');
Volt::route('/admin-panel-programs', 'logged-in-landing-page')->name('admin-panel-programs');
Volt::route('/admin-panel-videos', 'logged-in-landing-page')->name('admin-panel-videos');
Volt::route('/weather', 'weather')->name('weather');

Route::post('/upload', [FileUploads::class, 'store']);
Route::post('/upload-video', [FileUploads::class, 'storeVideo']);
