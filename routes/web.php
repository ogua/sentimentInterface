<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webcontroller;

Route::view('/', 'survey.index')
    ->name('home');

Route::view('survey/{record}', 'survey.start')
    ->name('survey.start');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

// Route::view('survey/questions/{record}', 'survey.survey-questions')
//     ->name('survey.questions')
//     ->middleware(['auth']);

Route::get('survey/questions/{record}',[Webcontroller::class,'surveyList'])
    ->name('survey.questions.record')
    ->middleware(['auth']);

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
