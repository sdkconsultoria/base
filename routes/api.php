
<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\Sdkconsultoria\Base\Http\Controllers\Admin')
->middleware('auth:sanctum')
->prefix('api/v1')->group(function () {
    Route::SdkApiResource('blog', 'Blog\BlogController');
    Route::SdkApiResource('blog-post', 'Blog\BlogPostController');
});
