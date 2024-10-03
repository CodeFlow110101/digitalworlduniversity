<?php

use App\Http\Controllers\FileUploads;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Volt::route('/', 'main-landing-page')->name('landing-page');
Volt::route('/sign-up', 'main-landing-page')->name('sign-up');
Volt::route('/log-in', 'main-landing-page')->name('log-in');
Volt::route('/terms-and-conditions', 'main-landing-page')->name('terms-and-conditions');
Volt::route('/privacy-policy', 'main-landing-page')->name('privacy-policy');
Volt::route('/refund-and-cancellation-policy', 'main-landing-page')->name('refund-and-cancellation-policy');

Volt::route('/dashboard', 'logged-in-landing-page')->name('dashboard');
Volt::route('/live-chat', 'logged-in-landing-page')->name('live-chat');
Volt::route('/find-jobs', 'logged-in-landing-page')->name('find-jobs');
Volt::route('/programs', 'logged-in-landing-page')->name('programs');
Volt::route('/videos', 'logged-in-landing-page')->name('videos');
Volt::route('/store', 'logged-in-landing-page')->name('store');
Volt::route('/settings', 'logged-in-landing-page')->name('settings');
Volt::route('/earn-money', 'logged-in-landing-page')->name('earn-money');
Volt::route('/video-player', 'logged-in-landing-page')->name('video-player');
Volt::route('/admin-panel', 'logged-in-landing-page')->name('admin-panel');
Volt::route('/admin-panel-users', 'logged-in-landing-page')->name('admin-panel-users');
Volt::route('/admin-panel-programs', 'logged-in-landing-page')->name('admin-panel-programs');
Volt::route('/admin-panel-videos', 'logged-in-landing-page')->name('admin-panel-videos');
Volt::route('/admin-panel-earn-money', 'logged-in-landing-page')->name('admin-panel-earn-money');
Volt::route('/admin-panel-video-player', 'logged-in-landing-page')->name('admin-panel-video-player');
Volt::route('/admin-panel-store', 'logged-in-landing-page')->name('admin-panel-store');
Volt::route('/admin-panel-find-jobs', 'logged-in-landing-page')->name('admin-panel-find-jobs');
Volt::route('/admin-panel-channel', 'logged-in-landing-page')->name('admin-panel-channel');
Volt::route('/admin-panel-group', 'logged-in-landing-page')->name('admin-panel-group');


Route::post('/upload-file', [FileUploads::class, 'storeFile']);
Route::post('/upload-video', [FileUploads::class, 'storeVideo']);
Route::post('/upload-thumbnail', [FileUploads::class, 'storeThumbnail']);

// Aamar Pay
Route::post('/payment-fail', [PaymentController::class, 'fail']);
Route::post('/payment-success', [PaymentController::class, 'success']);
Volt::route('/join-success', 'main-landing-page')->name('join-success');
Volt::route('/join-failure', 'main-landing-page')->name('join-failure');
