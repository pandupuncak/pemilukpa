<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

define("AUTH_SANCTUM", "auth:sanctum");

Route::middleware([AUTH_SANCTUM, 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'show'])->name('dashboard');

    Route::get('/vote', [VoteController::class, 'showVotePage'])->name('vote');
    Route::post('/vote/requests', [VoteController::class, 'createVoteRequest'])->name('vote.create');
});

Route::middleware([AUTH_SANCTUM, 'verified', 'can:admin-action'])->group(function () {
    Route::get('/vote/voters', [UserController::class, 'showVotersPage'])->name('vote.voters');

    Route::get('/vote/results', [VoteController::class, 'showVoteResultsPage'])->name('vote.results');
});

Route::middleware([AUTH_SANCTUM, 'verified', 'can:superadmin-action'])->group(function () {
    Route::get('/users', [UserController::class, 'show'])->name('users');
    Route::post('/users', [UserController::class, 'import'])->name('users.import');
    Route::post('/users/send-passwords', [UserController::class, 'sendPasswords'])->name('users.send-passwords');
    Route::get('/vote/requests', [VoteController::class, 'showVoteRequestsPage'])->name('vote.requests');
});
