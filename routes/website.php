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

Route::get('/blog', function () {
    return view('website.blog');
})->name('blog');

Route::get('/blog/{post}', function ($post) {
    return view('website.blog-detail', compact('post'));
})->name('blog.detail');

Route::get('/charity', function () {
    return view('website.charity');
})->name('charity');

Route::get('/services', function () {
    return view('website.services');
})->name('services');

Route::get('/gallery', function () {
    return view('website.gallery');
})->name('gallery');

Route::get('/contact', function () {
    return view('website.contact');
})->name('contact');

Route::post('/contact', function (Illuminate\Http\Request $request) {
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'subject' => 'required|in:consultation,quotation,support,complaint,other',
        'message' => 'required|string|max:2000',
    ]);

    // Create contact message
    \App\Models\ContactMessage::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
        'status' => 'new'
    ]);

    return redirect()->back()->with('success', 'پیام شما با موفقیت ارسال شد');
})->name('contact.submit');
//news routes just for test with message
Route::get('/news', function () {
    //show message that this is just for test with message that this is just for test without any view
    return "this is just for test";
})->name('news');
