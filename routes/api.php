<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\UserTopicsController;
use App\Http\Controllers\Api\UserCoursesController;
use App\Http\Controllers\Api\CourseTopicsController;
use App\Http\Controllers\Api\UserSectionsController;
use App\Http\Controllers\Api\SectionTopicsController;
use App\Http\Controllers\Api\UserHistoriesController;
use App\Http\Controllers\Api\CourseSectionsController;
use App\Http\Controllers\Api\TopicHistoriesController;
use App\Http\Controllers\Api\CourseHistoriesController;
use App\Http\Controllers\Api\SectionHistoriesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('courses', CourseController::class);

        // Course Sections
        Route::get('/courses/{course}/sections', [
            CourseSectionsController::class,
            'index',
        ])->name('courses.sections.index');
        Route::post('/courses/{course}/sections', [
            CourseSectionsController::class,
            'store',
        ])->name('courses.sections.store');

        // Course Topics
        Route::get('/courses/{course}/topics', [
            CourseTopicsController::class,
            'index',
        ])->name('courses.topics.index');
        Route::post('/courses/{course}/topics', [
            CourseTopicsController::class,
            'store',
        ])->name('courses.topics.store');

        // Course Histories
        Route::get('/courses/{course}/histories', [
            CourseHistoriesController::class,
            'index',
        ])->name('courses.histories.index');
        Route::post('/courses/{course}/histories', [
            CourseHistoriesController::class,
            'store',
        ])->name('courses.histories.store');

        Route::apiResource('sections', SectionController::class);

        // Section Topics
        Route::get('/sections/{section}/topics', [
            SectionTopicsController::class,
            'index',
        ])->name('sections.topics.index');
        Route::post('/sections/{section}/topics', [
            SectionTopicsController::class,
            'store',
        ])->name('sections.topics.store');

        // Section Histories
        Route::get('/sections/{section}/histories', [
            SectionHistoriesController::class,
            'index',
        ])->name('sections.histories.index');
        Route::post('/sections/{section}/histories', [
            SectionHistoriesController::class,
            'store',
        ])->name('sections.histories.store');

        Route::apiResource('topics', TopicController::class);

        // Topic Histories
        Route::get('/topics/{topic}/histories', [
            TopicHistoriesController::class,
            'index',
        ])->name('topics.histories.index');
        Route::post('/topics/{topic}/histories', [
            TopicHistoriesController::class,
            'store',
        ])->name('topics.histories.store');

        Route::apiResource('histories', HistoryController::class);

        Route::apiResource('users', UserController::class);

        // User Courses
        Route::get('/users/{user}/courses', [
            UserCoursesController::class,
            'index',
        ])->name('users.courses.index');
        Route::post('/users/{user}/courses', [
            UserCoursesController::class,
            'store',
        ])->name('users.courses.store');

        // User Sections
        Route::get('/users/{user}/sections', [
            UserSectionsController::class,
            'index',
        ])->name('users.sections.index');
        Route::post('/users/{user}/sections', [
            UserSectionsController::class,
            'store',
        ])->name('users.sections.store');

        // User Topics
        Route::get('/users/{user}/topics', [
            UserTopicsController::class,
            'index',
        ])->name('users.topics.index');
        Route::post('/users/{user}/topics', [
            UserTopicsController::class,
            'store',
        ])->name('users.topics.store');

        // User Histories
        Route::get('/users/{user}/histories', [
            UserHistoriesController::class,
            'index',
        ])->name('users.histories.index');
        Route::post('/users/{user}/histories', [
            UserHistoriesController::class,
            'store',
        ])->name('users.histories.store');
    });
