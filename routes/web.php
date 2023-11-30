<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MQTTController;
use App\Http\Controllers\historyController;
use Illuminate\Support\Facades\Artisan; 
use Symfony\Component\HttpFoundation\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Frontend
Route::get("/clear-cache", function () {
    $exitCode = Artisan::call('cache:clear'); 
});
Route::get('/', [HomeController::class,'index']);
Route::get('/trang-chu', [HomeController::class,'index']);
Route::get('/lich-su', [historyController::class,'history']);
Route::post('/search', [historyController::class,'search']);
Route::get('/thong-tin-ca-nhan', [HomeController::class,'information']);

Route::get('/subscribe', [MQTTController::class,'subscribe']);
Route::post('/send-mqtt-command', [MQTTController::class, 'sendMqttCommand'])->name('send-mqtt-command');
Route::post('/send-mqtt-commandoff', [MQTTController::class, 'sendMqttCommandoff'])->name('send-mqtt-commandoff');
Route::post('/send-mqtt-command2', [MQTTController::class, 'sendMqttCommand2'])->name('send-mqtt-command2');
Route::post('/send-mqtt-commandoff2', [MQTTController::class, 'sendMqttCommandoff2'])->name('send-mqtt-commandoff2');
Route::get('/on-off-times', [MQTTController::class, 'onOffTimes']);
