<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/tasks/filters/{status?}', [\App\Http\Controllers\Main\Task\FilterListController::class, 'filter'])
    ->name('tasks.filters');


//Route::middleware('auth')->group(function () {
    Route::get('/main', [\App\Http\Controllers\Main\Main\IndexController::class, 'index'])->name('main.index');
    Route::resource('/projects', \App\Http\Controllers\Main\Project\ProjectController::class);

    Route::resource('/tasks', \App\Http\Controllers\Main\Task\TaskController::class);
    Route::post('/tasks/{task}/comment', [\App\Http\Controllers\Main\Task\TaskController::class, 'comment']);
    Route::get('/tasks/{task}/comment', [\App\Http\Controllers\Main\Task\TaskController::class, 'commentList']);
    Route::patch('/tasks/{task}/review', [\App\Http\Controllers\Main\Task\TaskController::class, 'review'])
        ->name('tasks.review');
    Route::patch('/tasks/{task}/complete', [\App\Http\Controllers\Main\Task\TaskController::class, 'complete'])
        ->name('tasks.complete');
    Route::patch('/tasks/{task}/work', [\App\Http\Controllers\Main\Task\TaskController::class, 'work'])
        ->name('tasks.work');

//});


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin.check'],
], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Main\IndexController::class, 'index'])->name('main.index');
    Route::resource('/comments', \App\Http\Controllers\Admin\Comment\CommentController::class);
    Route::resource('/projects', \App\Http\Controllers\Admin\Project\ProjectController::class);
    Route::resource('/tasks', \App\Http\Controllers\Admin\Task\TaskController::class);
    Route::patch('/tasks/{task}/review', [\App\Http\Controllers\Admin\Task\TaskController::class, 'review'])
        ->name('tasks.review');
    Route::patch('/tasks/{task}/complete', [\App\Http\Controllers\Admin\Task\TaskController::class, 'complete'])
        ->name('tasks.complete');
    Route::patch('/tasks/{task}/work', [\App\Http\Controllers\Admin\Task\TaskController::class, 'work'])
        ->name('tasks.work');
    Route::resource('/users', \App\Http\Controllers\Admin\User\UserController::class);

});


require __DIR__ . '/auth.php';
