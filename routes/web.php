<?php

use App\Models\Lot;
use App\Enums\LotStatus;
use App\Livewire\HomePage;
use App\Livewire\LoginPage;
use App\Livewire\LotListPage;
use App\Livewire\ContactPage;
use App\Livewire\LotApplyPage;
use App\Livewire\RegisterPage;
use App\Models\LotWinningReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Livewire\LotDetailsPage;
use App\Livewire\VerifyPhonePage;
use App\Livewire\UserProfilePage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', HomePage::class)->name('home');

Route::middleware('guest')->group(function() {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('register', RegisterPage::class)->name('register');
});

Route::middleware('auth')->group(function() {
    Route::get('verify-phone', VerifyPhonePage::class)
        ->middleware('not-verified')
        ->name('verify-phone');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('profile', UserProfilePage::class)->name('user.profile');

    Route::get('lot-apply/{lot}', LotApplyPage::class)
        ->where('lot', '[0-9]+')
        ->name('lot.apply');
});

Route::get('contact', ContactPage::class)->name('contact');

Route::get('lot-list/{status}', LotListPage::class)
    ->whereIn('status', LotStatus::values())
    ->name('lots');

Route::get('lot-details/{lot}', LotDetailsPage::class)
    ->where('lot', '[0-9]+')
    ->name('lot.details');

Route::get('lot-report/{winningReport}/download', function(LotWinningReport $winningReport) {
    $pdf = Pdf::loadView('layouts.lot-report', ['winningReport' => $winningReport]);
    return $pdf->download("lot-report-$winningReport->id.pdf");
})->where('winningReport', '[0-9]+')->name('lot.report.pdf');

Route::get('lot-report/{winningReport}', function(LotWinningReport $winningReport) {
    return view('lot-report', ['winningReport' => $winningReport]);
})->where('winningReport', '[0-9]+')->name('lot.report');

Route::get('/test', function() {
    return view('test');
});

Route::view('{any}', 'layouts.404')->name('error.404');
