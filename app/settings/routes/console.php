<?php

use mavoc\console\Route;

Route::command('example', ['ConsoleController', 'example']);
Route::command('refresh', ['ConsoleController', 'refresh']);
Route::command('rsync', ['ConsoleController', 'rsync']);
Route::command('view', ['ConsoleController', 'view']);

