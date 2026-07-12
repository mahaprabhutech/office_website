<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'name' => 'Mahaprabhu Tech Innovation Corporate API',
    'status' => 'online',
]));
