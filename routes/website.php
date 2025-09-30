<?php

use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', function () {
    return view('website.home');
})->name('home');

Route::get('/about', function () {
    return view('website.about');
})->name('about');

Route::get('/projects', function () {
    return view('website.projects');
})->name('projects');

Route::get('/projects/{project}', function ($project) {
    return view('website.project-detail', compact('project'));
})->name('project.detail');

Route::get('/news', function () {
    return view('website.news');
})->name('news');

Route::get('/news/{news}', function ($news) {
    return view('website.news-detail', compact('news'));
})->name('news.detail');

Route::get('/services', function () {
    return view('website.services');
})->name('services');

Route::get('/gallery', function () {
    return view('website.gallery');
})->name('gallery');

Route::get('/contact', function () {
    return view('website.contact');
})->name('contact');

Route::post('/contact', function () {
    // Handle contact form submission
    return redirect()->back()->with('success', 'پیام شما با موفقیت ارسال شد');
})->name('contact.submit');
