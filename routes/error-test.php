<?php

use Illuminate\Http\Request;

// Routes for testing error pages
Route::prefix('test-errors')->group(function () {
    // Test 403 - Forbidden
    Route::get('403', function () {
        abort(403, 'This action is unauthorized.');
    });

    // Test 404 - Not Found
    Route::get('404', function () {
        abort(404, 'Page not found.');
    });

    // Test 419 - Token Expired / Page Expired
    Route::get('419', function () {
        abort(419, 'Page expired, please refresh and try again.');
    });

    // Test 429 - Too Many Requests
    Route::get('429', function () {
        abort(429, 'Too many requests.');
    });

    // Test 500 - Server Error
    Route::get('500', function () {
        abort(500, 'Server error occurred.');
    });

    // Test 503 - Service Unavailable
    Route::get('503', function () {
        abort(503, 'Service is temporarily unavailable.');
    });

    // Show all error test links
    Route::get('/', function () {
        $errors = [
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '419' => 'Token Expired',
            '429' => 'Too Many Requests',
            '500' => 'Server Error',
            '503' => 'Service Unavailable'
        ];
        
        return view('errors.test-errors', compact('errors'));
    })->name('error-tests');
});