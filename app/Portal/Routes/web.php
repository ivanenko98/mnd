<?php

Route::group(['prefix' => 'portal'], function() {
    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });

    Route::get('/', 'DashboardController@index')->name('dashboard');
});


