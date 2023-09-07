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
// Define middleware to check user roles based on their 'jabatan'
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:FINANCE,STAFF'])->group(function () {
        Route::post('/reimbursement', 'ReimbursementController@store');
    });

    Route::middleware(['role:DIREKTUR'])->group(function () {
        Route::get('/users/create', 'AdminUserController@create');
        Route::post('/users', 'AdminUserController@store');

        Route::get('/users/{user}/edit', 'AdminUserController@edit');
        Route::put('/users/{user}', 'AdminUserController@update');

        Route::delete('/users/{user}', 'AdminUserController@destroy');
    });

    Route::middleware(['role:FINANCE'])->group(function () {
        Route::get('/reimbursements/approved', 'ReimbursementController@getApprovedReimbursements');
    });

    Route::middleware(['role:DIREKTUR,FINANCE'])->group(function () {
        Route::post('/reimbursement/{reimbursement}/approve', 'ReimbursementController@approve');
        Route::post('/reimbursement/{reimbursement}/reject', 'ReimbursementController@reject');
    });
});



Route::get('/', function () {
    return view('welcome');
});
