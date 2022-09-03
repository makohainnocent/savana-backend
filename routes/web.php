<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\screenShotController;
use App\Http\Controllers\ComputerController;

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

Route::prefix('actions')->group([],function(){
   Route::get('add',function(){return "added";});
   Route::get('/delete',function(){return "deleted";});
});

Route::get('/books/title/{title}', function ($title) {
    return "hello world"."\n\nthe book tile is:".$title;
})->name('test.show')->middleware('signed');

Route::middleware('throttle:5,1')->get('/test', function () {
    return view('test');
});

Route::get('/task',[TaskController::class, 'index']);

Route::get('/db',[TaskController::class, 'db']);



Route::get('/putError/computer_serial/{computer_serial}/company_id/{company_id}/module/{module}/error/{error}',[ErrorsController::class, 'store']);

Route::post('/putScreenShot',[screenShotController::class, 'store']);

Route::get('/putComputer/computer_serial/{computer_serial}/company_id/{company_id}/cpuArch/{cpuArch}/osArch/{osArch}/osType/{osType}/computer_name/{computer_name}',[ComputerController::class, 'store']);