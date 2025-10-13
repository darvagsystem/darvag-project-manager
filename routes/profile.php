<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to user profile management.
| This includes profile viewing, editing, and updating.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // User Profile Routes
    Route::get('/profile', function () {
        return view('admin.users.show', ['user' => auth()->user()]);
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        $user = auth()->user();
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    })->name('profile.edit');

    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('panel.profile.show')->with('success', 'پروفایل با موفقیت به‌روزرسانی شد.');
    })->name('profile.update');

});
