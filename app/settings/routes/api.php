<?php

use mavoc\core\Route;

Route::get('api/v0/metric/users', ['APIMetricsController', 'users']);

Route::get('api/v0/hello', ['APIMiscController', 'hello']);
Route::post('api/v0/hello', ['APIMiscController', 'helloSubmit']);

// Private
Route::get('api/v0/settings', ['APISettingsController', 'settings'], 'private');
Route::get('api/v0/settings/timezones', ['APISettingsController', 'timezones'], 'private');
Route::post('api/v0/settings', ['APISettingsController', 'update'], 'private');

Route::get('api/v0/user', ['APIUsersController', 'read'], 'private'); 
Route::post('api/v0/user', ['APIUsersController', 'update'], 'private'); 
