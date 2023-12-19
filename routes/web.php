<?php

use App\Http\Controllers\AccountRecoveryController;
use App\Http\Controllers\ActionsPageController;
use App\Http\Controllers\ApplicantsController;
use App\Http\Controllers\CaptchaMgekController;
use App\Http\Controllers\LegalManualController;
use App\Http\Controllers\ListMgekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MainpageController;
use App\Http\Controllers\NiiNewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainpageController::class, 'index'])
    ->name('home');

Route::get('/legal', [LegalManualController::class, 'index'])
    ->name('legal');

Route::get('/legal/{legal:slug}', [LegalManualController::class, 'show'])
    ->name('legal-item');

Route::get('/actions', [ActionsPageController::class, 'index'])
    ->name('actions');

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [PostController::class, 'index'])
        ->name('index');

    Route::get('{post:slug}', [PostController::class, 'show'])
        ->name('show');
});

Route::prefix('nii_news')->name('nii_news.')->group(function () {
    Route::get('/', [NiiNewsController::class, 'index'])
        ->name('index');

    Route::get('/{news:id}', [NiiNewsController::class, 'show'])
        ->name('show');
});

Route::get('/contacts', [StaticPageController::class, 'contacts'])
    ->name('contacts');

Route::get('/faq', [QuestionController::class, 'index'])
    ->name('faq');

Route::get('/committee', [ListMgekController::class, 'index'])
    ->name('committee');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.perform');

Route::post('/register', [RegisterController::class, 'create'])
    ->name('register.perform');

Route::get('/verify/{token}', [RegisterController::class, 'verify'])
    ->name('register.verify');

Route::post('/sendmail', [AccountRecoveryController::class, 'create'])
    ->name('recovery.create');

Route::get('/recovery/{token}', [AccountRecoveryController::class, 'change'])
    ->name('recovery.perform');

Route::post('/recovery', [AccountRecoveryController::class, 'verify'])
    ->name('recovery.change');

Route::group(['middleware' => ['mgek.auth']], function () {
    Route::get('/logout', [LogoutController::class, 'perform'])
        ->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile_change', [ProfileController::class, 'changeProfile'])
        ->name('profile.change');

    Route::post('/profile_change_password', [ProfileController::class, 'changePassword'])
        ->name('profile.change.password');

    Route::post('/profile_change_avatar', [ProfileController::class, 'changeAvatar'])
        ->name('profile.change.avatar');

    Route::get('/profile/applicants', [ApplicantsController::class, 'index'])
        ->name('applicants.list');

    Route::get('/profile/applicants/{id}', [ApplicantsController::class, 'show'])
        ->name('applicants.show');

    Route::get('/verify_user/{id}', [ApplicantsController::class, 'verify'])
        ->name('user.verify');

    Route::get('/activate/{id}', [ApplicantsController::class, 'activate'])
        ->name('user.activate');

    Route::get('/renew/{id}', [ApplicantsController::class, 'renew'])
        ->name('user.renew');

    Route::get('/deactivate/{id}', [ApplicantsController::class, 'deactivate'])
        ->name('user.deactivate');

    Route::post('/reject', [ApplicantsController::class, 'reject'])
        ->name('user.reject');

    Route::middleware('check.user.role:admin,applicant,employee,participant')
        ->prefix('profile/statements')->name('statements.')->group(function () {
            Route::group(['middleware' => ['check.user.role:admin,employee']], function () {
                Route::get('complete/{statement}', [StatementController::class, 'complete'])->name('complete');
                Route::post('register/{statement}', [StatementController::class, 'register'])->name('register');
                Route::post('decide/{statement}', [StatementController::class, 'decide'])->name('decide');
            });

            Route::post('decide-expert/{statement}', [StatementController::class, 'decideExpert'])->name('decide.expert');
            Route::post('add-message/{statement}', [StatementController::class, 'addMessage'])->name('add_message');
            Route::get('create', [StatementController::class, 'create'])->name('create');
            Route::get('/', [StatementController::class, 'index'])->name('list');
            Route::post('/', [StatementController::class, 'store'])->name('store');
            Route::get('edit/{statement}', [StatementController::class, 'edit'])->name('edit');
            Route::post('update/{statement}', [StatementController::class, 'update'])->name('update');
            Route::get('/{statement}', [StatementController::class, 'destroy'])->name('delete');
            Route::get('show/{statement}', [StatementController::class, 'show'])->name('show');
        });
});

Route::get('/get_captcha/{config?}', [CaptchaMgekController::class, 'getCaptcha'])
    ->name('captcha.get');
