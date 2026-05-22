<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
});
