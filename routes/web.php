<?php

use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PollController::class, 'create'])->name('home');
Route::post('/polls', [PollController::class, 'store'])->name('storePoll');
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('showPoll');
