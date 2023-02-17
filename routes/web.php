<?php

Route::namespace('\Sdkconsultoria\Base\Http\Controllers\Admin')
->prefix('admin')
->middleware(['web', 'verified'])
->group(function () {
    Route::get('social-auth/{type}', 'SocialAuthController@login')->name('social-auth');
    Route::get('social-link/{type}', 'SocialAuthController@login')->name('social-auth-link');

    Route::middleware(['auth'])->group(function () {
        Route::SdkSimpleResource('role', 'Auth\RoleController');

        Route::namespace('Auth')
        ->middleware(['web'])->group(function () {
            Route::SdkResource('user', 'UserController');
            Route::get('profile', 'UserController@myAccount')->name('profile');
            Route::post('save-profile', 'UserController@saveAccount')->name('save.profile');
        });
    });
});
