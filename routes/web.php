<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/',[\App\Http\Controllers\HomeController::class,'index']);

Route::get('/admin', function () {
	$modules = Module::all();


	return view('admin.dashboard', [
		"modules" => $modules
	]);
})->name('admin.dashboard');

Route::get('/redirect', fn () => (redirect()->route('admin.dashboard')))->name('');
