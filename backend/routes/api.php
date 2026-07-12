<?php

use App\Http\Controllers\Api\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Api\Admin\JobController as AdminJobController;
use App\Http\Controllers\Api\Admin\JobApplicationController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\Admin\QuotationController as AdminQuotationController;
use App\Http\Controllers\Api\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\Admin\SettingsController;
use App\Http\Controllers\Api\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->group(function () {
    Route::get('/home', [PublicController::class, 'home']);
    Route::get('/services', [PublicController::class, 'services']);
    Route::get('/services/{service:slug}', [PublicController::class, 'service']);
    Route::get('/projects', [PublicController::class, 'projects']);
    Route::get('/projects/{project:slug}', [PublicController::class, 'project']);
    Route::get('/team', [PublicController::class, 'team']);
    Route::get('/jobs', [PublicController::class, 'jobs']);
    Route::get('/jobs/{job:slug}', [PublicController::class, 'job']);
    Route::get('/posts', [PublicController::class, 'posts']);
    Route::get('/posts/{blogPost:slug}', [PublicController::class, 'post']);
    Route::get('/settings', [PublicController::class, 'settings']);
});

Route::post('/contact', [SubmissionController::class, 'contact']);
Route::post('/quotations', [SubmissionController::class, 'quotation']);
Route::post('/jobs/{job}/apply', [SubmissionController::class, 'jobApplication']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class);

    Route::middleware('module:content')->group(function () {
        Route::apiResource('services', AdminServiceController::class);
        Route::apiResource('projects', AdminProjectController::class);
        Route::apiResource('team-members', AdminTeamMemberController::class);
        Route::apiResource('blog-posts', AdminBlogPostController::class);
        Route::apiResource('testimonials', AdminTestimonialController::class);
    });

    Route::middleware('module:hr')->group(function () {
        Route::apiResource('jobs', AdminJobController::class);
        Route::apiResource('job-applications', JobApplicationController::class)->only(['index', 'show', 'update']);
        Route::get('/job-applications/{jobApplication}/resume', [JobApplicationController::class, 'resume']);
    });

    Route::middleware('module:sales')->group(function () {
        Route::apiResource('enquiries', AdminEnquiryController::class)->only(['index', 'show', 'update']);
        Route::apiResource('quotations', AdminQuotationController::class)->only(['index', 'show', 'update']);
    });

    Route::middleware('module:settings')->group(function () {
        Route::apiResource('users', AdminUserController::class);
        Route::get('/settings', [SettingsController::class, 'index']);
        Route::put('/settings', [SettingsController::class, 'update']);
    });
});
