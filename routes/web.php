<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/register',[HomeController::class,'registerPage'])->name('register.page');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/channels/{channel}', [VideoController::class,'videos'])->name('channel');
Route::get('/watch/{video}', [VideoController::class,'video'])->name('video.watch');

Route::group(['middleware' => ['web','auth']], function (){

    Route::get('/channel/{channel}/create',[VideoController::class,'videoUploadPage'])->name('video.page');
    Route::post('/channel/{channel}/create',[VideoController::class,'videoUpload'])->name('videos.store');

    Route::get('/videos/{channel}/{video}/edit', [VideoController::class,'videoEditPage'])->name('video.edit.page');
    Route::post('/videos/{channel}/{video}/edit', [VideoController::class,'videoEdit'])->name('video.edit');

    Route::get('/profile/{id}',[UserController::class, 'updatePage'])->name('profile.page');
    Route::post('/profile/{id}',[UserController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin', function () {
	$modules = Module::all();

	return view('admin.dashboard', [
		"modules" => $modules
	]);
})->name('admin.dashboard');

Route::get('/redirect', fn () => (redirect()->route('admin.dashboard')))->name('');
