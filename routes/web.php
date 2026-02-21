<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\CheckIfUserCanVote;
use Illuminate\Support\Facades\Route;

Route::get('/', [PollController::class, 'create'])->name('home');
Route::post('/polls', [PollController::class, 'store'])->name('storePoll');
Route::get('/{poll:slug}', [PollController::class, 'show'])
    ->name('showPoll')
    ->middleware(CheckIfUserCanVote::class);
Route::post('/votes/{poll:slug}', [VoteController::class, 'store'])
    ->name('storeVote')
    ->middleware(CheckIfUserCanVote::class);
