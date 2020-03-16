<?php

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

Route::middleware('auth:airlock')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:airlock')->get('/users', function (Request $request) {
   return response()->json(App\User::all()); 
});

Route::post('/login', 'LoginController@authenticate');

Route::middleware('auth:airlock')->get('/jobs', function (Request $request) {
    return response()->json(\App\Job::with('customer')->get());
});

Route::middleware('auth:airlock')->get('/jobs/{id}', function ($id) {
    return response()->json(\App\Job::where('id', $id)->with(['customer', 'activities' => function ($q) {
        $q->orderBy('created_at', 'desc');
    }, 'comments' => function ($q) {
        $q->orderBy('created_at', 'asc');
    }])->first());
});

Route::middleware('auth:airlock')->post('/jobs/{id}', 'JobsController@update');
Route::middleware('auth:airlock')->post('/jobs/{id}/notification', 'JobsController@send_notification');

Route::middleware('auth:airlock')->post('/comment', 'CommentController@store');
Route::middleware('auth:airlock')->post('/comment/{id}/delete', 'CommentController@delete');
Route::middleware('auth:airlock')->get('/activity/{job_id}', 'ActivityController@view');