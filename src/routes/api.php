<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::post('/items/{id}/upload-image', [ItemController::class, 'uploadImage']);

