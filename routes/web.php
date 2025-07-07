<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\LoginToken;

Route::get('/qr-login/{token}', function ($token) {
    $tokenExists = LoginToken::where('token', $token)->exists();

    if (!$tokenExists) {
        abort(404);
    }

    return view('qr-login', ['token' => $token]);
})->name('qr.login');
