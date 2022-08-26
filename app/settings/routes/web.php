<?php

use mavoc\core\Route;

Route::get('/', ['MainController', 'home']);
Route::get('pricing', ['MainController', 'pricing']);
Route::get('terms', ['MainController', 'terms']);
Route::get('privacy', ['MainController', 'privacy']);

Route::get('contact', ['ContactController', 'contact']);
Route::post('contact', ['ContactController', 'contactPost']);


// Private
Route::get('account', ['AuthController', 'account'], 'private');
Route::post('account', ['AuthController', 'accountPost'], 'private');
Route::post('logout', ['AuthController', 'logout'], 'private');


// Public
Route::get('login', ['AuthController', 'login'], 'public');
Route::post('login', ['AuthController', 'loginPost'], 'public');
Route::post('register', ['AuthController', 'registerPost'], 'public');


