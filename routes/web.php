<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TotalHoursController;
use App\Http\Controllers\UploadedFilesController;
use App\Http\Controllers\UploadFilesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']],function(){
    Route::get('/', function () {return view('welcome');})->name('dashboard');

    Route::resource('places', PlacesController::class);
    Route::post('places/find-place', [PlacesController::class, 'findPlace'])->name('places.findPlace');

    Route::resource('users', UsersController::class);
    Route::post('users/find-user', [UsersController::class, 'findUser'])->name('users.findUser');
    Route::post('users/find-bus', [UsersController::class, 'findBus'])->name('users.findBus');
    Route::get('week-jobs', [JobsController::class, 'weekJobs']);
    Route::get('/test', [TestController::class, 'index'])->name('test');


    Route::resource('categories', CategoriesController::class);
    Route::post('categories/find-category', [CategoriesController::class, 'findCategory'])->name('categories.findCategory');
    Route::resource('posts', PostsController::class);
//Route::resource('uploaded-files', UploadedFilesController::class);
    Route::controller(UploadFilesController::class)->group(function(){
        Route::get('uploaded-files', 'index')->name('uploadfiles.index');
        Route::get('upload-files/users', 'selectUser')->name('uploadfiles.selectUsers');
        Route::get('upload-files/user/{user}', 'uploadToUser')->name('uploadfiles.uploadTouser');
        Route::get('files/user/{user}', 'getUserFiles')->name('uploadfiles.getUserFiles');
        Route::post('upload-files/user/{user}/store', 'store')->name('uploadfiles.upload');
        Route::delete('upload-files/{file}/', 'destroy')->name('uploadfiles.destroy');
    });

    Route::get('events/user/{user?}', [EventsController::class, 'index'])->name('events.searchByUser');
    Route::put('events/updateDate', [EventsController::class, 'updateDate'])->name('events.updateDate');
    Route::get('events/{id}/getEvents', [EventsController::class, 'getEvents'])->name('events.getEvents');
    Route::post('events/{event}/getData', [EventsController::class, 'getData'])->name('events.getData');
    Route::resource('events', EventsController::class);


    Route::get('total-hours', [TotalHoursController::class, 'index'])->name('totalHours.index');
    Route::post('total-hours', [TotalHoursController::class, 'sumOfHoursInWeek'])->name('totalHours.getHours');
});
require __DIR__.'/auth.php';

