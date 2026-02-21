<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Admin\SkillController;
use App\Http\Controllers\API\Admin\ExperienceController;
use App\Http\Controllers\API\Admin\ProjectController;
use App\Http\Controllers\API\Admin\EducationController;
use App\Http\Controllers\API\Admin\CertificationController;
use App\Http\Controllers\API\Admin\ProfileSectionController;
use App\Http\Controllers\API\Admin\ContactInfoController;
use App\Http\Controllers\API\Admin\ResumeTemplateController;
use App\Http\Controllers\API\PortfolioController;
use App\Http\Controllers\API\ResumeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes (rate-limited)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    // Admin Routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Only admins can register new users
        Route::post('/auth/register', [AuthController::class, 'register']);
        Route::apiResource('skills', SkillController::class);
        Route::apiResource('experiences', ExperienceController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('education', EducationController::class);
        Route::apiResource('certifications', CertificationController::class);
        Route::apiResource('profile-sections', ProfileSectionController::class);
        Route::apiResource('contact-info', ContactInfoController::class);
        Route::apiResource('templates', ResumeTemplateController::class);
    });
});

// Resume Generation Routes
Route::prefix('resumes')->group(function () {
    // Authenticated resume actions (rate-limited)
    Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
        Route::post('/analyze', [ResumeController::class, 'analyze']);
        Route::post('/generate', [ResumeController::class, 'generate']);
    });

    // Public resume viewing (rate-limited)
    Route::middleware('throttle:30,1')->group(function () {
        Route::get('/{token}', [ResumeController::class, 'show']);
        Route::get('/{token}/download', [ResumeController::class, 'download']);
    });
});

// Public Portfolio Routes (rate-limited)
Route::prefix('portfolio')->middleware('throttle:60,1')->group(function () {
    Route::get('/full', [PortfolioController::class, 'full']);
    Route::get('/profile', [PortfolioController::class, 'profile']);
    Route::get('/skills', [PortfolioController::class, 'skills']);
    Route::get('/experiences', [PortfolioController::class, 'experiences']);
    Route::get('/projects', [PortfolioController::class, 'projects']);
    Route::get('/education', [PortfolioController::class, 'education']);
    Route::get('/certifications', [PortfolioController::class, 'certifications']);
    Route::get('/contact', [PortfolioController::class, 'contact']);
});
