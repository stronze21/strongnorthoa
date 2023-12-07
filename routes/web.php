<?php

use App\Http\Livewire\Shows\AddShow;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Shows\ViewShow;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Shows\BookedShows;
use App\Http\Livewire\Shows\CookedShows;
use App\Http\Livewire\Profile\Masterlist;
use App\Http\Livewire\Orders\AgreementList;
use App\Http\Livewire\Orders\AgreementView;
use App\Http\Livewire\Reports\UserDashboard;
use App\Http\Livewire\Reports\GeneralDashboard;
use App\Http\Controllers\SignaturePadController;
use App\Http\Livewire\Profile\LifechangerProfile;


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
    Route::get('/lifechanger-profile', LifechangerProfile::class)->name('lc.profile');
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

    Route::get('signaturepad/{oa_id}', [SignaturePadController::class, 'index'])->name('signaturepad');
    Route::post('signaturepad', [SignaturePadController::class, 'upload'])->name('signaturepad.upload');
});