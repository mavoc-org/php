<?php

use mavoc\core\Route;

Route::get('/', ['MainController', 'home']);
Route::get('about', ['MainController', 'about']);
Route::get('pricing', ['MainController', 'pricing']);
Route::get('terms', ['MainController', 'terms']);
Route::get('privacy', ['MainController', 'privacy']);
Route::get('test', ['MainController', 'test']);

Route::get('contact', ['ContactController', 'contact']);
Route::post('contact', ['ContactController', 'contactSubmit']);

Route::get('documentation', ['DocumentationController', 'introduction']);
Route::get('documentation/authentication', ['DocumentationController', 'authentication']);
Route::get('documentation/request', ['DocumentationController', 'request']);
Route::get('documentation/response', ['DocumentationController', 'response']);
Route::get('documentation/sandbox', ['DocumentationController', 'sandbox']);
Route::get('documentation/client', ['DocumentationController', 'client']);
Route::get('documentation/cli', ['DocumentationController', 'cli']);
Route::get('documentation/changelog', ['DocumentationController', 'changelog']);
Route::get('documentation/endpoints', ['DocumentationController', 'endpoints']);
Route::get('documentation/endpoint/metrics', ['DocumentationController', 'metrics']);
Route::get('documentation/endpoint/miscellaneous', ['DocumentationController', 'miscellaneous']);
Route::get('documentation/endpoint/settings', ['DocumentationController', 'settings']);
Route::get('documentation/endpoint/user', ['DocumentationController', 'user']);

Route::get('documentation/download', ['DocumentationController', 'download']);


// Private
Route::get('account', ['AccountsController', 'account'], 'private');
Route::post('account', ['AccountsController', 'update'], 'private');

Route::get('settings', ['SettingsController', 'settings'], 'private');
Route::post('settings', ['SettingsController', 'update'], 'private');

Route::get('api-keys', ['APIKeysController', 'list'], 'private');
Route::get('api-key/add', ['APIKeysController', 'add'], 'private');
Route::get('api-key/copy', ['APIKeysController', 'copy'], 'private');
Route::post('api-key/add', ['APIKeysController', 'create'], 'private');
Route::post('api-key/delete/{id}', ['APIKeysController', 'delete'], 'private');
Route::get('change-password', ['AuthController', 'changePassword'], 'private');
Route::post('change-password', ['AuthController', 'changePasswordSave'], 'private');
Route::post('logout', ['AuthController', 'logout'], 'private');


// Public
Route::get('forgot-password', ['AuthController', 'forgotPassword'], 'public');
Route::post('forgot-password', ['AuthController', 'forgotPasswordSubmit'], 'public');
Route::get('login', ['AuthController', 'login'], 'public');
Route::post('login', ['AuthController', 'loginSubmit'], 'public');
Route::post('register', ['AuthController', 'registerSubmit'], 'public');
Route::get('reset-password', ['AuthController', 'resetPassword'], 'public');
Route::post('reset-password', ['AuthController', 'resetPasswordSubmit'], 'public');


