<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardPageController;
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
    Route::get('/', [DashboardPageController::class, 'index'])->name('dashboard');

    Route::resource('places', PlacesController::class);
    Route::post('places/find-place', [PlacesController::class, 'findPlace'])->name('places.findPlace');

    Route::resource('users', UsersController::class);
    Route::post('users/find-user', [UsersController::class, 'findUser'])->name('users.findUser');
    Route::post('users/find-bus', [UsersController::class, 'findBus'])->name('users.findBus');

    Route::get('week-jobs', [JobsController::class, 'weekJobs'])->name('jobs.index');
    Route::get('daily-jobs/{date}', [JobsController::class, 'dailyJobs'])->name('jobs.dailyJobs');
    Route::post('jobs/store', [JobsController::class, 'store'])->name('jobs.store');
    Route::post('absencese/store', [JobsController::class, 'absenceseStore'])->name('absencese.store');
    Route::post('jobs/getData', [JobsController::class, 'getData'])->name('jobs.getData');
    Route::post('absencese/getData', [JobsController::class, 'absenceseGetData'])->name('absencese.getData');
    Route::put('jobs/update-all', [JobsController::class, 'updateAll'])->name('jobs.updateAll');
    Route::put('jobs/update/{job}', [JobsController::class, 'update'])->name('jobs.update');
    Route::put('absencese/update/{absent}', [JobsController::class, 'absenceseUpdate'])->name('absencese.update');
    Route::delete('jobs/{job}', [JobsController::class, 'destroy'])->name('jobs.destroy');
    Route::delete('absencese/{absent}', [JobsController::class, 'absenceseDestroy'])->name('absencese.destroy');
    Route::post('jobs/store-absencese', [JobsController::class, 'storeAbsencese'])->name('jobs.storeAbsencese');
    Route::get('jobs/get-week-jobs', [JobsController::class, 'getWeekJobs'])->name('jobs.getWeekJobs');
    Route::get('jobs/week-jobs', [JobsController::class, 'weekJobsIndex'])->name('jobs.weekJobsIndex');
    Route::get('jobs/daily-jobs', [JobsController::class, 'dayJobsIndex'])->name('jobs.dayJobs');

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

