<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailVerificationController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ProfileSectionController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\ResumeTemplateController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\PortfolioPageController;
use App\Http\Controllers\ResumePageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::middleware('track')->group(function () {
    Route::get('/', [PortfolioPageController::class, 'index'])->name('portfolio');
    Route::get('/about', [PortfolioPageController::class, 'about'])->name('portfolio.about');
    Route::get('/experience', [PortfolioPageController::class, 'experience'])->name('portfolio.experience');
    Route::get('/projects', [PortfolioPageController::class, 'projects'])->name('portfolio.projects');
    Route::get('/contact', [PortfolioPageController::class, 'contact'])->name('portfolio.contact');

    // Legacy redirects (merged pages)
    Route::get('/skills', fn () => redirect()->route('portfolio.about'))->name('portfolio.skills');
    Route::get('/education', fn () => redirect()->route('portfolio.experience'))->name('portfolio.education');

    Route::get('/resume/create', [ResumePageController::class, 'create'])->name('resume.create');
    Route::get('/resume/{token}', [ResumePageController::class, 'view'])->name('resume.view');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

Route::get('/admin/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('admin.forgot-password');
Route::post('/admin/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('throttle:5,1')
    ->name('admin.forgot-password.submit');
Route::get('/admin/reset-password', [PasswordResetController::class, 'showResetForm'])->name('admin.reset-password');
Route::post('/admin/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware('throttle:5,1')
    ->name('admin.reset-password.submit');

Route::middleware('auth')->group(function () {
    Route::get('/admin/verify-email', [EmailVerificationController::class, 'notice'])->name('admin.verification.notice');
    Route::get('/admin/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('admin.verification.verify');
    Route::post('/admin/verify-email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:3,1')
        ->name('admin.verification.resend');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (authenticated + role:admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('skills', SkillController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('experiences', ExperienceController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('projects', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('education', EducationController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('certifications', CertificationController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('contact-info', ContactInfoController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('profile-sections', ProfileSectionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('templates', ResumeTemplateController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('settings', [SiteSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/profile-image', [SiteSettingsController::class, 'updateProfileImage'])->name('settings.profile-image.update');
    Route::delete('settings/profile-image', [SiteSettingsController::class, 'removeProfileImage'])->name('settings.profile-image.destroy');

    Route::get('theme', [ThemeController::class, 'index'])->name('theme.index');
    Route::put('theme', [ThemeController::class, 'update'])->name('theme.update');
    Route::post('theme/reset', [ThemeController::class, 'reset'])->name('theme.reset');

    Route::post('uploads', [FileUploadController::class, 'upload'])->name('uploads.store');
    Route::delete('uploads', [FileUploadController::class, 'destroy'])->name('uploads.destroy');

    // Database Management
    Route::get('database', [DatabaseController::class, 'index'])->name('database.index');
    Route::post('database/backup', [DatabaseController::class, 'createBackup'])->name('database.backup.create');
    Route::get('database/backup/{filename}', [DatabaseController::class, 'downloadBackup'])->name('database.backup.download');
    Route::delete('database/backup/{filename}', [DatabaseController::class, 'deleteBackup'])->name('database.backup.delete');
    Route::post('database/restore', [DatabaseController::class, 'restoreBackup'])->name('database.backup.restore');
    Route::post('database/migrate', [DatabaseController::class, 'runMigrations'])->name('database.migrate');
    Route::post('database/seed', [DatabaseController::class, 'runSeeders'])->name('database.seed');
    Route::post('database/cache-clear', [DatabaseController::class, 'clearCache'])->name('database.cache-clear');
    Route::get('database/table/{table}', [DatabaseController::class, 'tableDetails'])->name('database.table.details');
    Route::post('database/truncate', [DatabaseController::class, 'truncateTable'])->name('database.truncate');
});
