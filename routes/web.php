<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PollController::class, 'create'])->name('home');
Route::post('/polls', [PollController::class, 'store'])->name('storePoll');
Route::get('/{poll:slug}', [PollController::class, 'show'])->name('showPoll');
Route::post('/votes/{poll:slug}', [VoteController::class, 'store'])->name('storeVote');
