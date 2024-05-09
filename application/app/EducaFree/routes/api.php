<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    //Rutas datos
    Route::get('/courses/data', [HomeController::class, 'dataCourses'])->name('courses.data');
    Route::get('/coursesRandoms/data', [HomeController::class, 'dataRandomCourses'])->name('randomCourses.data');
    Route::get('/ranking/data/{id?}', [UserController::class, 'dataRanking'])->name('users.ranking');
    Route::get('/coursesInfo/data/{id}', [HomeController::class, 'dataCoursesInfo'])->name('coursesInfo.data');
    Route::get('/favorites/data/{id}', [HomeController::class, 'dataFavorites'])->name('coursesFavorites.data');
    Route::get('/comments/data/{id}', [CommentController::class, 'dataCourseComments'])->name('course.comments');
    Route::get('/courses/pending', [CourseController::class, 'dataPendings'])->name('coursesPendings.boolean');

    //Rutas datos dashboard
    Route::get('/courses/dashboard/data', [DashboardController::class, 'dataCourses'])->name('courses.dashboard.data');
    Route::get('/pendingcourses/dashboard/data', [DashboardController::class, 'dataPendingCourses'])->name('pendingcourses.dashboard.data');
    Route::get('/users/data', [DashboardController::class, 'dataUsers'])->name('users.data');
    Route::get('/requests/data', [DashboardController::class, 'dataRequests'])->name('requests.data');
    Route::get('/reports/data', [DashboardController::class, 'dataReports'])->name('reports.data');
    Route::get('/users/count', [DashboardController::class, 'countUsersByTimeRange']);
    Route::get('/courses/count', [DashboardController::class, 'countCoursesByTimeRange']);
    Route::get('/requests/count', [DashboardController::class, 'countRequestsByTimeRange']);
    Route::get('/mostliked/count', [DashboardController::class, 'countMostLikedByTimeRange']);
    Route::get('/completed/count', [DashboardController::class, 'countCompletedByTimeRange']);
    Route::get('/lticonsumer/count', [DashboardController::class, 'countLtiConsumerByTimeRange']);

    //Ruta subir archivos
    Route::post('/upload/image', [PointController::class, 'uploadImage']);

    //Ruta para hacer peticiones a la AI
    Route::post('/ai/request', [AIController::class, 'request']);

    //Ruta para checkear email
    Route::get('/checkemail/data', [UserController::class, 'checkEmail']);