<?php

Route::namespace('\Sdkconsultoria\Base\Http\Controllers\Admin')
->prefix('admin')
->middleware(['web'])
->group(function () {
    Route::get('social-auth/{type}', 'SocialAuthController@login')->name('social-auth');
    Route::get('social-link/{type}', 'SocialAuthController@login')->name('social-auth-link');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('my-account', 'UserController@myAccount')->name('my_account');

        Route::middleware(['role:admin'])->group(function () {
            Route::resource('users', 'UserController');
            Route::post('save-account', 'UserController@saveAccount')->name('save.my_account');

            Route::resource('blogs', 'BlogController');
            Route::resource('blog-posts', 'BlogPostController');
            Route::resource('tags', 'TagController');

            Route::resource('image-types', 'ImageTypeController');
            Route::resource('image-groups', 'ImageGroupController');
            Route::post('images/type/{id}', 'ImageController@setType')->name('image.set-type');
            Route::post('images/{class}/{id}', 'ImageController@upload')->name('image.upload');
            Route::post('images/single/{class}/{id}', 'ImageController@uploadSingle')->name('image.upload-single');
            Route::put('images/{id}', 'ImageController@edit')->name('image.edit');
            Route::delete('images/{id}', 'ImageController@destroy')->name('image.destroy');

            Route::post('tags/{class}/{id}', 'TagController@add')->name('tag.add');
            Route::delete('tags/{class}/{tag}/{id}', 'TagController@delete')->name('tag.delete');

            Route::post('subscription', 'SubscriptionController@addEmail')->name('subscription.new');
            Route::get('subscription/csv', 'SubscriptionController@csv')->name('subscription.csv');
            Route::get('subscription/{id}/{key}', 'SubscriptionController@removeEmail')->name('subscription.remove');

            Route::resource('key-groups', 'KeyGroupController');
            Route::resource('keys', 'KeyController');
        });
    });
});
