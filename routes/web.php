<?php

use App\Http\Controllers\VoteController;
use App\Models\Award;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {

    $dados = Award::where('is_active', true)
        ->get();
    return view('home', compact('dados'));
});

Route::get('/voting/{award_id}', function ($award_id) {
    $award = Award::where('id', $award_id)
        ->where('is_active', true)
        ->with(['categories.nominees'])
        ->firstOrFail();

    $userVotes = [];
    if (Auth::check()) {
        $userVotes = Vote::where('user_id', Auth::id())
            ->whereIn('category_id', $award->categories->pluck('id'))
            ->get()
            ->keyBy('category_id');
    }

    return view('votingSession', compact('award', 'userVotes'));
})->name('votingSession');

Route::post('/voting/{award_id}/vote', [VoteController::class, 'store'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('vote.store');

Route::delete('/voting/{award_id}/vote', [VoteController::class, 'destroy'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('vote.destroy');
