<?php

Route::namespace('\Sdkconsultoria\Base\Http\Controllers\Admin')
->prefix('admin')
->middleware(['web'])
->group(function () {
    Route::get('social-auth/{type}', 'SocialAuthController@login')->name('social-auth');
    Route::get('social-link/{type}', 'SocialAuthController@login')->name('social-auth-link');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::SdkSimpleResource('role', 'Auth\RoleController');

        Route::namespace('Auth')
        ->middleware(['web'])->group(function () {
            Route::SdkResource('user', 'UserController');
            Route::get('profile', 'UserController@myAccount')->name('profile');
            Route::post('save-profile', 'UserController@saveAccount')->name('save.profile');
        });

//
        // Route::middleware(['role:admin'])->group(function () {
//             Route::resource('users', 'UserController');
//             Route::post('new-token', 'UserController@createToken')->name('user.new-token');
//             Route::delete('delete-token/{id}', 'UserController@deleteToken')->name('user.delete-token');
//
//             Route::resource('blogs', 'BlogController');
//             Route::resource('blog-posts', 'BlogPostController');
//             Route::resource('tags', 'TagController');
//
//             Route::resource('image-sizes', 'ImageSizeController');
//             Route::resource('image-types', 'ImageTypeController');
//             Route::resource('image-groups', 'ImageGroupController');
//             Route::post('images/type/{id}', 'ImageController@setType')->name('image.set-type');
//             Route::post('images/{class}/{id}', 'ImageController@upload')->name('image.upload');
//             Route::post('images/single/{class}/{id}', 'ImageController@uploadSingle')->name('image.upload-single');
//             Route::put('images/{id}', 'ImageController@edit')->name('image.edit');
//             Route::delete('images/{id}', 'ImageController@destroy')->name('image.destroy');
//
//             Route::post('tags/{class}/{id}', 'TagController@add')->name('tag.add');
//             Route::delete('tags/{class}/{tag}/{id}', 'TagController@delete')->name('tag.delete');
//
//             Route::post('subscription', 'SubscriptionController@addEmail')->name('subscription.new');
//             Route::get('subscription/csv', 'SubscriptionController@csv')->name('subscription.csv');
//             Route::get('subscription/{id}/{key}', 'SubscriptionController@removeEmail')->name('subscription.remove');
//
//             Route::resource('key-groups', 'KeyGroupController');
//             Route::resource('keys', 'KeyController');
//
//             Route::post('related/{id}/{model}/{id_2}/{model_2}', 'RelatedController@create')->name('related.create');
//             Route::delete('related/{id}/{model}/{id_2}/{model_2}', 'RelatedController@delete')->name('related.delete');
        // });
    });
});
