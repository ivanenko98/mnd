<?php


use App\Http\Resources\UserResource;
use App\Portal\Helpers\Acl;
use App\Portal\Helpers\Faker;
use App\Portal\Helpers\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    Route::post('auth/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');



        // Skills
        Route::group(['prefix' => 'skills'], function () {
            Route::get('/', 'SkillController@index')->middleware('permission:' . Acl::PERMISSION_SKILLS_LIST);
        });

        // Users
        Route::get('/user', 'UserController@showCurrentUser');
        Route::get('users/masters', 'UserController@listMasters');
        Route::apiResource('users', 'UserController')->except(['show', 'update'])->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::get('users/{user}', 'UserController@show');
        Route::post('users/{user}/upload-avatar', 'UserController@uploadAvatar');
        Route::post('users/set-lang', 'UserController@setLanguage');

        // Orders

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'OrderController@index')->middleware('permission:' . Acl::PERMISSION_ORDERS_MANAGE . '|' . Acl::PERMISSION_ORDERS_MANAGE_MY);
            Route::post('/', 'OrderController@store')->middleware('permission:' . Acl::PERMISSION_ORDERS_MANAGE);
            Route::put('/{order}', 'OrderController@update')->middleware('permission:' . Acl::PERMISSION_ORDERS_MANAGE);
            Route::get('/{order}', 'OrderController@show')->middleware('permission:' . Acl::PERMISSION_ORDERS_MANAGE . '|' . Acl::PERMISSION_ORDERS_MANAGE_MY);
            Route::post('/{order}/cancel', 'OrderController@cancel')->middleware('permission:' . Acl::PERMISSION_ORDERS_MANAGE);
        });

        // Services
        Route::group(['prefix' => 'services'], function () {
            Route::get('/', 'ServiceController@index')->middleware('permission:' . Acl::PERMISSION_SERVICES_LIST);
        });

        // Cities
        Route::group(['prefix' => 'cities'], function () {
            Route::get('/', 'CityController@index')->middleware('permission:' . Acl::PERMISSION_CITIES_LIST);
        });

        // Api resource routes
        Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // Custom routes
        Route::put('users/{user}', 'UserController@update');
        Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
    });
});

// Fake APIs
Route::get('/table/list', function () {
    $rowsNumber = mt_rand(20, 30);
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'author' => Faker::randomString(mt_rand(5, 10)),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'id' => mt_rand(100000, 100000000),
            'pageviews' => mt_rand(100, 10000),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'title' => Faker::randomString(mt_rand(20, 50)),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

//Route::get('/orders', function () {
//    $rowsNumber = 8;
//    $data = [];
//    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
//        $row = [
//            'order_no' => 'LARAVUE' . mt_rand(1000000, 9999999),
//            'price' => mt_rand(10000, 999999),
//            'status' => Faker::randomInArray(['success', 'pending']),
//        ];
//
//        $data[] = $row;
//    }
//
//    return response()->json(new JsonResponse(['items' => $data]));
//});

Route::get('/articles', function () {
    $rowsNumber = 10;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'id' => mt_rand(100, 10000),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'title' => Faker::randomString(mt_rand(20, 50)),
            'author' => Faker::randomString(mt_rand(5, 10)),
            'comment_disabled' => Faker::randomBoolean(),
            'content' => Faker::randomString(mt_rand(100, 300)),
            'content_short' => Faker::randomString(mt_rand(30, 50)),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'forecast' => mt_rand(100, 9999) / 100,
            'image_uri' => 'https://via.placeholder.com/400x300',
            'importance' => mt_rand(1, 3),
            'pageviews' => mt_rand(10000, 999999),
            'reviewer' => Faker::randomString(mt_rand(5, 10)),
            'timestamp' => Faker::randomDateTime()->getTimestamp(),
            'type' => Faker::randomInArray(['US', 'VI', 'JA']),

        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data, 'total' => mt_rand(1000, 10000)]));
});

Route::get('articles/{id}', function ($id) {
    $article = [
        'id' => $id,
        'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
        'title' => Faker::randomString(mt_rand(20, 50)),
        'author' => Faker::randomString(mt_rand(5, 10)),
        'comment_disabled' => Faker::randomBoolean(),
        'content' => Faker::randomString(mt_rand(100, 300)),
        'content_short' => Faker::randomString(mt_rand(30, 50)),
        'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
        'forecast' => mt_rand(100, 9999) / 100,
        'image_uri' => 'https://via.placeholder.com/400x300',
        'importance' => mt_rand(1, 3),
        'pageviews' => mt_rand(10000, 999999),
        'reviewer' => Faker::randomString(mt_rand(5, 10)),
        'timestamp' => Faker::randomDateTime()->getTimestamp(),
        'type' => Faker::randomInArray(['US', 'VI', 'JA']),

    ];

    return response()->json(new JsonResponse($article));
});

Route::get('articles/{id}/pageviews', function ($id) {
    $pageviews = [
        'PC' => mt_rand(10000, 999999),
        'Mobile' => mt_rand(10000, 999999),
        'iOS' => mt_rand(10000, 999999),
        'android' => mt_rand(10000, 999999),
    ];
    $data = [];
    foreach ($pageviews as $device => $pageview) {
        $data[] = [
            'key' => $device,
            'pv' => $pageview,
        ];
    }

    return response()->json(new JsonResponse(['pvData' => $data]));
});
