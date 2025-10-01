<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    OnboardingController,
    DashboardController,
};
use App\Http\Controllers\Web\OverviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Applicant\UserJobsController; // <-- Added correct namespace
use App\Http\Controllers\User\Applicant\UserApplicationController;

use App\Http\Controllers\User\Applicant\{
    ApplicantProfileController,
    ApplicantLocationController,
    ExperienceController,
    EducationController,
    ApplicantCertificationController,
    VoluntaryDisclosureController,
    CareerDashboardController,
};


// -----------------------------
// Applicant-only onboarding routes
// -----------------------------
Route::middleware(['auth', 'ensure.applicant'])->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('step1', [OnboardingController::class, 'step1'])->name('step1');
    Route::post('step1', [OnboardingController::class, 'postStep1'])->name('postStep1');

    Route::get('step2', [OnboardingController::class, 'step2'])->name('step2');
    Route::post('step2', [OnboardingController::class, 'postStep2'])->name('postStep2');

    Route::get('step3', [OnboardingController::class, 'step3'])->name('step3');
    Route::post('step3', [OnboardingController::class, 'postStep3'])->name('postStep3');

    Route::get('step4', [OnboardingController::class, 'step4'])->name('step4');
    Route::post('step4', [OnboardingController::class, 'postStep4'])->name('postStep4');

    Route::get('step5', [OnboardingController::class, 'step5'])->name('step5');
    Route::post('step5', [OnboardingController::class, 'postStep5'])->name('postStep5');

    Route::get('review', [OnboardingController::class, 'review'])->name('review');
    Route::post('submit', [OnboardingController::class, 'submit'])->name('submit');
});

// -----------------------------
// Applicant dashboard & profile CRUD routes (role:4)
// -----------------------------
Route::middleware(['auth', 'role:4'])->prefix('user/applicant')->name('user.applicant.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'applicant'])->name('dashboard');
    Route::get('/dashboard/overview', [CareerDashboardController::class, 'index'])->name('dashboard.overview');
    Route::view('/loading_count_down', 'loading_count_down');

    // Applicant profile CRUD (user table)
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('index'); // show form
        Route::put('/update', [ProfileController::class, 'update'])->name('update'); // update
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy'); // delete
    });

    // Full resource routes for all applicant-related models
    // Explicit ApplicantProfile routes
Route::prefix('profiles')->group(function () {
    Route::get('/', [ApplicantProfileController::class, 'index'])
        ->name('profiles.index');
    Route::get('create', [ApplicantProfileController::class, 'create'])
        ->name('profiles.create');
    Route::post('store', [ApplicantProfileController::class, 'store'])
        ->name('profiles.store');
    Route::get('{profile}/edit', [ApplicantProfileController::class, 'edit'])
        ->name('profiles.edit');
    Route::put('{profile}', [ApplicantProfileController::class, 'update'])
        ->name('profiles.update');
    Route::delete('{profile}', [ApplicantProfileController::class, 'destroy'])
        ->name('profiles.destroy');
});


    Route::resource('locations', ApplicantLocationController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('educations', EducationController::class);
    Route::resource('certifications', ApplicantCertificationController::class);

    Route::get('voluntary_disclosures/edit', [VoluntaryDisclosureController::class, 'edit'])->name('voluntary_disclosures.edit');
    Route::put('voluntary_disclosures', [VoluntaryDisclosureController::class, 'update'])->name('voluntary_disclosures.update');

    // Jobs routes
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::get('/', [UserJobsController::class, 'index'])->name('index');        // List all jobs
        Route::get('/{slug}', [UserJobsController::class, 'show'])->name('show');   // View single job
    });

    // Job application form & submission
// Jobs dashboard routes
    Route::get('jobs/{slug}/apply', [UserApplicationController::class, 'create'])->name('jobs.apply');
    Route::post('jobs/{slug}/apply', [UserApplicationController::class, 'store'])->name('jobs.apply.store');

    // Overview route
    Route::get('/overviews', [OverviewController::class, 'index'])->name('overviews.index');
});
