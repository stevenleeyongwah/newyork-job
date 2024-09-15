<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job', [App\Http\Controllers\JobController::class, 'jobSearch'])->name('home');
Route::get('/job/search', [App\Http\Controllers\JobController::class, 'search'])->name('job_search');
Route::get('/job/by-id/{id}', [App\Http\Controllers\JobController::class, 'getJobById'])->name('job_by_id');
Route::get('/job/{id}/{title}', [App\Http\Controllers\JobController::class, 'view'])->name('job_view');
Route::get('/job/{slug}', [App\Http\Controllers\JobController::class, 'jobSearch'])->name('home');
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap_index');