<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\RedirectToHttps;
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

//Rutas genericas
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/conditions', [HomeController::class, 'conditions'])->name('conditions');
Route::get('/course/pdf/{id}', [CourseController::class, 'exportPdf'])->name('course.exportPdf');

//Rutas de la LTI
Route::any('/lti', [App\Http\Controllers\LtiController::class, 'launch']);
Route::get('/lti/jwks', [App\Http\Controllers\LtiController::class, 'getJWKS']);
Route::get('/course/{id}/{cmid?}', [CourseController::class, 'show'])->name('course');

//Rutas para recuperar contraseña
Route::get('/reset', [UserController::class, 'reset'])->name('reset');
Route::post('/forgot', [UserController::class, 'sendEmail'])->name('sendEmail');
Route::post('/resetpassword', [UserController::class, 'resetPassword'])->name('reset-password');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    //Rutas dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/lessons', [DashboardController::class, 'lessons'])->name('dashboard.lessons');

    Route::get('/dashboard/requests', [DashboardController::class, 'requests'])->name('dashboard.requests');
    Route::delete('/dashboard/requests/{id}', [RequestController::class, 'delete'])->name('request.delete');
    Route::put('/dashboard/requests/{id}', [RequestController::class, 'complete'])->name('request.complete');

    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::delete('/dashboard/users/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/dashboard/users/giveAdmin/{id}', [UserController::class, 'giveAdmin'])->name('user.giveAdmin');
    Route::post('/dashboard/users/giveEditor/{id}', [UserController::class, 'giveEditor'])->name('user.giveEditor');
    Route::post('/dashboard/users/giveCollaborator/{id}', [UserController::class, 'giveCollaborator'])->name('user.giveCollaborator');
    Route::post('/dashboard/users/deleteRoles/{id}', [UserController::class, 'deleteRoles'])->name('user.deleteRoles');

    Route::get('/dashboard/courses', [DashboardController::class, 'courses'])->name('dashboard.courses');
    Route::delete('/dashboard/courses/{id}', [CourseController::class, 'delete'])->name('course.delete');
    Route::get('/dashboard/courses/edit/{id}', [DashboardController::class, 'editCourse'])->name('dashboard.course');
    Route::get('/dashboard/courses/preview/{id}', [DashboardController::class, 'preview'])->name('dashboard.preview');

    Route::get('/dashboard/pendingCourses', [DashboardController::class, 'pendingCourses'])->name('dashboard.pendingCourses');
    Route::post('/dashboard/pendingCourses/{id}', [CourseController::class, 'accept'])->name('course.accept');

    Route::post('/dashboard/courses/edit/{id}', [LessonController::class, 'addLesson'])->name('course.addLesson');
    Route::post('/dashboard/courses/edit/{id}/{courseId}', [PointController::class, 'addPoint'])->name('course.addPoint');
    Route::post('/dashboard/courses/addPDF/{id}/{courseId}', [LessonController::class, 'addPDF'])->name('course.addPDF');
    Route::post('/dashboard/courses/editPDF/{id}/{courseId}', [LessonController::class, 'addPDF'])->name('course.editPDF');
    Route::post('/dashboard/courses/deletePDF/{id}/{courseId}', [LessonController::class, 'deletePDF'])->name('course.deletePDF');
    
    Route::delete('/dashboard/courses/edit/deleteLesson/{id}/{courseId}', [LessonController::class, 'deleteLesson'])->name('course.deleteLesson');
    Route::delete('/dashboard/courses/edit/deletePoint/{id}/{courseId}', [PointController::class, 'deletePoint'])->name('course.deletePoint');
    Route::put('/dashboard/courses/edit/editLesson/{id}/{courseId}', [LessonController::class, 'editLesson'])->name('course.editLesson');
    Route::put('/dashboard/courses/edit/editPoint/{id}/{courseId}', [PointController::class, 'editPoint'])->name('course.editPoint');

    Route::post('/dashboard/courses/', [CourseController::class, 'addCourse'])->name('dashboard.addCourse');
    Route::put('/dashboard/courses/edit/editCourse/{id}', [CourseController::class, 'editCourse'])->name('course.editCourse');
    Route::put('/dashboard/courses/vision/{id}', [CourseController::class, 'visionOn'])->name('course.vision');
    Route::put('/dashboard/courses/visioff/{id}', [CourseController::class, 'visionOff'])->name('course.visioff');

    Route::get('/dashboard/reports', [DashboardController::class, 'reports'])->name('dashboard.reports');
    Route::delete('/dashboard/report/{id}', [ReportController::class, 'pass'])->name('report.pass');
    Route::delete('/dashboard/deleteComment/{idComment}/{type}', [ReportController::class, 'deleteComment'])->name('report.delete');
 
    // Rutas Cursos
    Route::post('/course/report/{id}/{type}/{reason}', [ReportController::class, 'report'])->name('comment.report');
    Route::post('/course/updateInfo/{id}', [CourseController::class, 'updateInfo'])->name('courses.updateInfo');
    Route::post('/course/addFavorites/{id}', [CourseController::class, 'addFavorites'])->name('courses.addFavorites');
    Route::post('/course/comment/addFavorites/{id}/{idCourse}', [CommentController::class, 'addFavorites'])->name('comments.addFavorites');
    Route::post('/course/comment/{id}', [CommentController::class, 'comment'])->name('course.comment');
    Route::post('/course/replyComment/{id}', [CommentController::class, 'replyComment'])->name('course.replyComment');
    Route::put('/course/editComment/{id}', [CommentController::class, 'editComment'])->name('course.editComment');
    Route::put('/course/editReply/{id}', [CommentController::class, 'editReply'])->name('course.editReply');
    Route::delete('/course/deleteComment/{id}/{idCourse}', [CommentController::class, 'deleteComment'])->name('course.deleteComment');
    Route::delete('/course/deleteReply/{id}/{idCourse}', [CommentController::class, 'deleteReply'])->name('course.deleteReply');

    Route::get('/pendingCourse/delete', [HomeController::class, 'deletePendingCourse'])->name('pendingcourse.delete');
    Route::get('/pendingCourse/delete/new', [HomeController::class, 'deletePendingCourseNew'])->name('pendingcourse.deletenew');

    Route::get('/upload/{id?}/{name?}/{description?}', [HomeController::class, 'upload'])->name('upload');
    Route::get('/uploadAP', [DashboardController::class, 'upload'])->name('uploadAP');

    //Rutas Home
    Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
    // Route::get('/course/{id}', [CourseController::class, 'show']);
    Route::get('/request', [HomeController::class, 'request'])->name('request');
    // Route::get('/course/{id}', [CourseController::class, 'show'])->name('course');
    Route::post('/request', [RequestController::class, 'store'])->name('home.store');
    

    //Rutas de login y register se encuentran en:
    // EducaFree/app/providers/JetstreamServiceProvider.php

    //Rutas del profile se encuentran en:
    // vendor/laravel/jetstream/src/Http/Controllers/Inertia/UserProfileController.php
    // vendor/laravel/jetstream/routes/liveware.php
    // vendor/laravel/jetstream/routes/inertia.php

    //Rutas de usuario
    Route::put('/user/profile/update/{id}', [UserController::class, 'updateInfo'])->name('user.update');
    Route::put('/user/profile/updatePassword/{id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::delete('/user/profile/delete/{id}', [UserController::class, 'deleteYourself'])->name('user.deleteYourself');
});

//Mismas rutas fuera del middleware para poder utilizar sus metodos sin la necesidad de estar verificados
Route::put('/user/profile/update/{id}', [UserController::class, 'updateInfo'])->name('user.update');
Route::put('/user/profile/updatePassword/{id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');
Route::delete('/user/profile/delete/{id}', [UserController::class, 'deleteYourself'])->name('user.deleteYourself');

