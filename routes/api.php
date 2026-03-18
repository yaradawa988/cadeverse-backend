<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\APIAuthController;
use App\Http\Controllers\CheckController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function()
{    //user
     Route::post("/logout",[APIAuthController::class,'logout']);
     Route::post('/profile',[UserController::class,'profile']);
     Route::post('/users/{user}', [UserController::class,'update']);
   





     //lessons
     Route::get('/lessons', [UserController::class, 'getLessons']);
     Route::get('/lesson/{lessonId}', [UserController::class, 'getLessonDetails']);
     Route::get('/lesson/{lessonId}/content/{level}', [UserController::class, 'getLessonContent']);
     Route::post('/progress', [UserController::class, 'saveProgress']);
     Route::get('/completed-lessons', [UserController::class, 'completedLessons']);
     Route::post('/lesson/{lessonId}/mark-completed', [UserController::class, 'markLessonAsCompleted']);
     Route::post('/favorites/{lessonId}', [UserController::class, 'addToFavorites']);
     Route::delete('/favorites/{lessonId}', [UserController::class, 'removeFromFavorites']);
     Route::get('/lessons/{lessonId}/content/{contentId}', [UserController::class, 'getSingleLessonContent']);
     
     Route::get('/user/lessons/{lessonId}/progress', [UserController::class, 'getProgress']);
     Route::get('/user/progress', [UserController::class, 'getAllProgress']);
     Route::get('/favorites', [UserController::class, 'getFavorites']);






     Route::post('/lessons/{id}/add', [UserController::class, 'addLessonToMyList']);
     Route::delete('/lessons/{id}/remove', [UserController::class, 'removeLessonFromMyList']);
     Route::get('/lessons/my-list', [UserController::class, 'myLessonList']);
 



    //tests
     Route::get('/tests', [UserController::class, 'getAllTests']); 
     Route::get('/lesson/{lessonId}/tests', [UserController::class, 'getTestsByLesson']);
     Route::get('/test/{testId}', [UserController::class, 'getTestDetails']);
     Route::get('/test/{testId}/result', [UserController::class, 'getTestResult']); 
     Route::get('/user/tests/results', [UserController::class, 'getUserResults']); 

     Route::post('/tests/{testId}/submit', [UserController::class, 'submitTest']);

     Route::get('/monthly-top-scorers', [UserController::class, 'viewMonthlyTopScorers']);
     
     Route::get('/monthly-top-scorers', [UserController::class, 'viewMonthlyTopScorers']);
    
     Route::get('/test/{testId}/participate', [UserController::class, 'participateInTest']);

     Route::get('/test/{testId}/results', [UserController::class, 'viewTestResults']);
 




     
  //chat
  Route::post('/checks/store', [CheckController::class, 'store']);
  Route::get('/users/{id}/checks', [CheckController::class, 'usermessages']);
  Route::get('/checks', [CheckController::class, 'index']);
  Route::get('/showResults', [CheckController::class, 'showResults']);
  Route::delete('/messages/{id}', [CheckController::class, 'destroymessage']);
  Route::get('message/{id}', [CheckController::class, 'showMessage']);

    });
    // Public Routes
    Route::post('/login',[APIAuthController::class,'login']);
    Route::post('/register',[APIAuthController::class,'register']);
    
Route::post('/reset-password', [APIAuthController::class,'reset_password']);
Route::post('/send-password-reset-email', [APIAuthController::class,'send_password_reset_email']);