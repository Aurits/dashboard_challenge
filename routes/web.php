<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/upload-school', [AdminController::class, 'uploadSchool'])->name('admin.uploadSchool');
Route::post('/admin/upload-questions', [AdminController::class, 'uploadQuestions'])->name('admin.uploadQuestions');
Route::post('/admin/create-challenge', [AdminController::class, 'createChallenge'])->name('admin.createChallenge');
Route::post('/admin/upload-answer', [AdminController::class, 'uploadAnswer'])->name('admin.uploadAnswer');

// Delete routes
Route::delete('/admin/delete-school/{schoolRegNo}', [AdminController::class, 'deleteSchool'])->name('admin.deleteSchool');
Route::delete('/admin/delete-challenge/{challengeNo}', [AdminController::class, 'deleteChallenge'])->name('admin.deleteChallenge');
Route::delete('/admin/delete-question/{questionNo}', [AdminController::class, 'deleteQuestion'])->name('admin.deleteQuestion');
