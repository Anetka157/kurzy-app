<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('courses.index'));

Route::resource('courses', CourseController::class);
Route::resource('participants', ParticipantController::class)->except(['show']);

Route::post('courses/{course}/enroll', [EnrollmentController::class, 'store'])
    ->name('courses.enroll');

Route::patch('enrollments/{enrollment}/status', [EnrollmentController::class, 'updateStatus'])
    ->name('enrollments.updateStatus');
