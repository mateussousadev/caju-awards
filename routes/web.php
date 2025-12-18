<?php

use App\CategoryType;
use App\Http\Controllers\Admin\PresentationController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AuthController;
use App\Models\Award;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', function () {
    $dados = Award::where('is_active', true)->get();
    return view('home', compact('dados'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/voting/{award_id}/vote', [VoteController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('vote.store');

    Route::delete('/voting/{award_id}/vote', [VoteController::class, 'destroy'])
        ->middleware('throttle:10,1')
        ->name('vote.destroy');
});

Route::get('/voting/{award_id}', function ($award_id) {
    $award = Award::where('id', $award_id)
        ->where('is_active', true)
        ->with([
            'categories' => function ($query) {
                $query->where('type', CategoryType::PUBLIC_VOTE);
            },
            'categories.nominees'
        ])
        ->firstOrFail();

    $userVotes = Vote::where('user_id', Auth::id())
        ->whereIn('category_id', $award->categories->pluck('id'))
        ->get()
        ->keyBy('category_id');

    return view('votingSession', compact('award', 'userVotes'));
})->middleware('auth')->name('votingSession');

Route::post('/voting/{award_id}/vote', [VoteController::class, 'store'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('vote.store');

Route::delete('/voting/{award_id}/vote', [VoteController::class, 'destroy'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('vote.destroy');

// Presentation Routes (Admin Only)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/presentation/{award}', [PresentationController::class, 'show'])
        ->name('presentation.show');
});
