<?php

use App\Http\Controllers\BotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return Telegram::bot('mybot')->getMe();
});

Route::get('/bot/getupdates', function() {
    $updates = Telegram::getUpdates();
    foreach ($updates as $update) {
        return json_encode($update->getMessage()->message_id);
    }
});

Route::get('bot/sendmessage', function() {
    Telegram::sendMessage([
        'chat_id' => '2068212230',
        'text' => 'Hello world!'
    ]);
    return;
});

Route::post('/telegram/bot/webhook', [BotController::class, 'webhook']);