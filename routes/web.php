<?php

use App\Models\Award;
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
        ->with('categories.nominees')
        ->firstOrFail();
    return view('votingSession', compact('award'));
})->name('votingSession');
