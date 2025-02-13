<?php

use App\Http\Controllers\SignaturePadController;
use App\Http\Livewire\Contests\CsCreate;
use App\Http\Livewire\Contests\CsList;
use App\Http\Livewire\Contests\CsView;
use App\Http\Livewire\Orders\AgreementList;
use App\Http\Livewire\Orders\AgreementView;
use App\Http\Livewire\Profile\AssociateForm;
use App\Http\Livewire\Profile\LifechangerProfile;
use App\Http\Livewire\Profile\Masterlist;
use App\Http\Livewire\Profile\RegisterLc;
use App\Http\Livewire\QrCodes;
use App\Http\Livewire\Report\AdminBookedShows;
use App\Http\Livewire\Report\AdminCookedShows;
use App\Http\Livewire\Reports\GeneralDashboard;
use App\Http\Livewire\Reports\UserDashboard;
use App\Http\Livewire\Shows\AddShow;
use App\Http\Livewire\Shows\BookedShows;
use App\Http\Livewire\Shows\CookedShows;
use App\Http\Livewire\Shows\ViewShow;
use Illuminate\Support\Facades\Auth;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', GeneralDashboard::class)->name('gen.dashboard');
    Route::get('/dashboard', GeneralDashboard::class)->name('dashboard');
    Route::get('/lifechanger-profile/update/{userID?}', LifechangerProfile::class)->name('lc.profile');
    Route::get('/lifechanger-profile/create/{userID?}', RegisterLc::class)->name('lc.create');
    Route::get('/lifechanger-profile/assoc-form/{userID}', AssociateForm::class)->name('lc.assoc.form');
    Route::get('/lifechanger-masterlist', Masterlist::class)->name('lc.masterlist');

    Route::prefix('/cookingshows')->name('cs.')->group(function () {
        Route::get('/', BookedShows::class)->name('booked');
        Route::get('/cookedshows', CookedShows::class)->name('cooked');
        Route::get('/add', AddShow::class)->name('add');
        Route::get('/view/{cs_id}', ViewShow::class)->name('view');
    });

    Route::prefix('/order-agreements')->name('oa.')->group(function () {
        Route::get('/', AgreementList::class)->name('list');
        Route::get('/{oa_id}', AgreementView::class)->name('view');
    });

    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/booked-shows', AdminBookedShows::class)->name('booked');
        Route::get('/cooked-shows', AdminCookedShows::class)->name('cooked');
    });

    Route::get('/contests', CsList::class)->middleware('auth')->name('contests.list');
    Route::get('/contests/view/{contest_id}', CsView::class)->middleware('auth')->name('contests.view');
    Route::get('/contests/create', CsCreate::class)->name('contests.create');

    Route::get('signaturepad/{oa_id}', [SignaturePadController::class, 'index'])->name('signaturepad');
    Route::post('signaturepad', [SignaturePadController::class, 'upload'])->name('signaturepad.upload');

    Route::get('qr-codes', QrCodes::class)->name('qrs');
    Route::view('post-show', 'emails.post-cs-questionaire');
});