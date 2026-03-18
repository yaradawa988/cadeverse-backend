<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile',[AdminController::class,'profile'])->name('profile');
Route::put('/users/{user}',[AdminController::class,'update']);
Route::get('/users', [AdminController::class, 'index']);
Route::get('/users/{user}/edit',[AdminController::class,'edit']);
Route::get('/users/{user}/delete',[AdminController::class,'destroy']);



Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
Route::get('/lessons/{id}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
Route::post('/lessons/{id}', [LessonController::class, 'update'])->name('lessons.update');
Route::delete('/lessons/{id}', [LessonController::class, 'destroy'])->name('lessons.destroy');

Route::get('/lessons/{lesson_id}/content', [LessonController::class, 'addContentForm'])->name('lessons.addContentForm');
Route::post('/lessons/{lesson_id}/content', [LessonController::class, 'addContent'])->name('lessons.addContent');
//Route::delete('/lesson-content/{id}', [LessonController::class, 'removeContent'])->name('lessons.removeContent');

Route::put('/lessons/content/update/{id}', [LessonController::class, 'updateContent'])->name('lessons.updateContent');

Route::get('/lessons/content/edit/{id}', [LessonController::class, 'editContent'])->name('lessons.editContent');
//Route::post('/lessons/content/update/{id}', [LessonController::class, 'updateContent'])->name('lessons.updateContent');
Route::delete('/lessons/content/delete/{id}', [LessonController::class, 'deleteContent'])->name('lessons.deleteContent');

Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');




// Route to view all tests
Route::get('/tests', [TestController::class, 'index'])->name('tests.index');

// Route to create a new test
Route::get('tests/create', [TestController::class, 'create'])->name('tests.create');

// Route to show test details and add questions
Route::get('tests/{id}', [TestController::class, 'show'])->name('tests.show');

// Route to store a new test
Route::post('/tests', [TestController::class, 'store'])->name('tests.store');

// Route to update a test
Route::get('/tests/{test}/edit', [TestController::class, 'edit'])->name('tests.edit');

Route::put('tests/{id}', [TestController::class, 'update']);

// Route to delete a test
Route::delete('/tests/{test}', [TestController::class, 'destroy'])->name('tests.destroy');

Route::resource('questions', QuestionController::class);
Route::get('/questions/create/{test_id}', [QuestionController::class, 'create'])->name('questions.create');

//Route::get('/questions/create/{test_id}', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question}/edit/{test_id}', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('/questions/{question}/{test_id}', [QuestionController::class, 'update'])->name('questions.update');

Route::delete('/questions/{question}/{test_id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
// مسار عرض نتائج المستخدم
Route::get('/results/{userId}', [TestController::class, 'showResults']);
Route::resource('tests', TestController::class);