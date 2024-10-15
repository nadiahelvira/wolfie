<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', 'App\Http\Controllers\DashboardController@index')->middleware(['auth']);
Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth']);
// Chart Dashboard
Route::get('/chart', 'App\Http\Controllers\ChartController@chart')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant']);
Route::get('/cheatsheet', 'App\Http\Controllers\CheatsheetController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer']);
//User Edit
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->middleware(['auth']);
Route::post('/profile/update', 'App\Http\Controllers\ProfileController@update')->middleware(['auth']);
Route::post('/profile/setting/update', 'App\Http\Controllers\ProfileController@updateSetting')->middleware(['auth']);

// Periode
Route::post('/periode', 'App\Http\Controllers\PeriodeController@index')->middleware(['auth'])->name('periode');
Route::get('/kosongi', 'App\Http\Controllers\HomeController@kosong')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant']);
Route::get('/perbaiki', 'App\Http\Controllers\HomeController@hitungUlang')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant']);

// Posting
Route::get('/posting/index', 'App\Http\Controllers\PostingController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner']);
Route::post('/posting/proses', 'App\Http\Controllers\PostingController@posting')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner']);
Route::get('/posting/browsebukti', 'App\Http\Controllers\PostingController@browsebukti')->middleware(['auth']);
Route::post('/posting/bukaposting', 'App\Http\Controllers\PostingController@bukaposting')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner']);

// Master Account
Route::get('/account', 'App\Http\Controllers\FMaster\AccountController@index')->middleware(['auth'])->name('account');
Route::post('/account/store', 'App\Http\Controllers\FMaster\AccountController@store')->middleware(['auth'])->name('account/store');
Route::get('/account/create', 'App\Http\Controllers\FMaster\AccountController@create')->middleware(['auth'])->name('account/create');
Route::get('/raccount', 'App\Http\Controllers\FReport\RAccountController@report')->middleware(['auth'])->name('raccount');
    // GET ACCOUNT
    Route::get('/get-account', 'App\Http\Controllers\FMaster\AccountController@getAccount')->middleware(['auth'])->name('get-account');
    Route::get('/account/browse', 'App\Http\Controllers\FMaster\AccountController@browse')->middleware(['auth'])->name('accoumt/browse');
    Route::get('/account/browsecash', 'App\Http\Controllers\FMaster\AccountController@browsecash')->middleware(['auth'])->name('accoumt/browsecash');
    Route::get('/account/browsebank', 'App\Http\Controllers\FMaster\AccountController@browsebank')->middleware(['auth'])->name('accoumt/browsebank');
    Route::get('/account/browsecashbank', 'App\Http\Controllers\FMaster\AccountController@browsecashbank')->middleware(['auth'])->name('accoumt/browsecashbank');
    Route::get('/account/browseallacc', 'App\Http\Controllers\FMaster\AccountController@browseallacc')->middleware(['auth'])->name('accoumt/browseallacc');
    Route::get('/get-account-report', 'App\Http\Controllers\FReport\RAccountController@getAccountReport')->middleware(['auth'])->name('get-account-report');
    Route::post('/jasper-account-report', 'App\Http\Controllers\FReport\RAccountController@jasperAccountReport')->middleware(['auth']);
    Route::get('account/cekacc', 'App\Http\Controllers\FMaster\AccountController@cekacc')->middleware(['auth']);
    Route::get('account/browseKel', 'App\Http\Controllers\FMaster\AccountController@browseKel')->middleware(['auth']);
// Dynamic Account
Route::get('/account/show/{account}', 'App\Http\Controllers\FMaster\AccountController@show')->middleware(['auth'])->name('accountid');
Route::get('/account/edit', 'App\Http\Controllers\FMaster\AccountController@edit')->middleware(['auth'])->name('account.edit');

//Route::get('/account/edit', 'App\Http\Controllers\FMaster\AccountController@edit')->middleware(['auth'])->name('account.edit');


Route::post('/account/update/{account}', 'App\Http\Controllers\FMaster\AccountController@update')->middleware(['auth'])->name('account.update');
Route::get('/account/delete/{account}', 'App\Http\Controllers\FMaster\AccountController@destroy')->middleware(['auth'])->name('account.delete');

// Report Rugi Laba
Route::get('/rrl', 'App\Http\Controllers\FReport\RRlController@report')->middleware(['auth'])->name('rrl');
Route::get('/get-rl-report', 'App\Http\Controllers\FReport\RRlController@getRlReport')->middleware(['auth'])->name('get-rl-report');
Route::post('/jasper-rl-report', 'App\Http\Controllers\FReport\RRlController@jasperRlReport')->middleware(['auth']);

// Report Neraca
Route::get('/rnera', 'App\Http\Controllers\FReport\RNeraController@report')->middleware(['auth'])->name('rnera');
Route::get('/get-nera-report', 'App\Http\Controllers\FReport\RNeraController@getNeraReport')->middleware(['auth'])->name('get-nera-report');
Route::post('/jasper-nera-report', 'App\Http\Controllers\FReport\RNeraController@jasperNeraReport')->middleware(['auth']);


// Manage User
Route::get('/user/manage', 'App\Http\Controllers\UserController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('user/manage');
Route::get('/user/add', 'App\Http\Controllers\UserController@create')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('user/add');
Route::post('/user/add', 'App\Http\Controllers\UserController@store')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('user/add');
    // GET USER
    Route::get('/get-user', 'App\Http\Controllers\UserController@getUser')->middleware(['auth'])->name('get-user');
// Dynamic User
Route::get('/user/show/{user}', 'App\Http\Controllers\UserController@show')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('userid');
Route::get('/user/edit/{user}', 'App\Http\Controllers\UserController@edit')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('useredit');
Route::get('/user/delete/{user}', 'App\Http\Controllers\UserController@destroy')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('userid');
Route::post('/user/update/{user}', 'App\Http\Controllers\UserController@update')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner'])->name('userid');



// Operational Memo
Route::get('/memo', 'App\Http\Controllers\FTransaksi\MemoController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('memo');
Route::post('/memo/store', 'App\Http\Controllers\FTransaksi\MemoController@store')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('memo/store');
Route::get('/rmemo', 'App\Http\Controllers\FReport\RMemoController@report')->middleware(['auth'])->name('rmemo');
    // GET MEMO
    Route::get('/get-memo', 'App\Http\Controllers\FTransaksi\MemoController@getMemo')->middleware(['auth'])->name('get-memo');
    Route::get('/get-memo-report', 'App\Http\Controllers\FReport\RMemoController@getMemoReport')->middleware(['auth'])->name('get-memo-report');
    Route::post('memo/jasper-memo-report', 'App\Http\Controllers\FReport\RMemoController@jasperMemoReport')->middleware(['auth']);
// Dynamic Memo
Route::get('/memo/edit', 'App\Http\Controllers\FTransaksi\MemoController@edit')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('memo.edit');
Route::post('/memo/update/{memo}', 'App\Http\Controllers\FTransaksi\MemoController@update')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('memo.update');
Route::get('/memo/delete/{memo}', 'App\Http\Controllers\FTransaksi\MemoController@destroy')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('memo.delete');
    
    //Report
    Route::post('/rmemo/cetak', 'App\Http\Controllers\FReport\RMemoController@cetak')->middleware(['auth'])->name('rmemo.cetak');

// Operational Kas Masuk
Route::get('/kas', 'App\Http\Controllers\FTransaksi\KasController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas');
Route::post('/kas/store', 'App\Http\Controllers\FTransaksi\KasController@store')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas/store');
Route::get('/kas_validasi', 'App\Http\Controllers\FTransaksi\KasController@create_validasi')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas_validasi');


Route::get('/kas/browse_bukti', 'App\Http\Controllers\FTransaksi\KasController@browse_bukti')->middleware(['auth'])->name('kas/browse_bukti');
 
Route::get('/rkas', 'App\Http\Controllers\FReport\RKasController@report')->middleware(['auth'])->name('rkas');
    // GET KAS
    Route::get('/get-kas', 'App\Http\Controllers\FTransaksi\KasController@getKas')->middleware(['auth'])->name('get-kas');
    Route::get('/get-kas-report', 'App\Http\Controllers\FReport\RKasController@getKasReport')->middleware(['auth'])->name('get-kas-report');
    Route::post('rkas/jasper-kas-report', 'App\Http\Controllers\FReport\RKasController@jasperKasReport')->middleware(['auth']);
// Dynamic Kas Masuk
Route::get('/kas/edit', 'App\Http\Controllers\FTransaksi\KasController@edit')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas.edit');
Route::post('/kas/update/{kas}', 'App\Http\Controllers\FTransaksi\KasController@update')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas.update');
Route::get('/kas/delete/{kas}', 'App\Http\Controllers\FTransaksi\KasController@destroy')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('kas.delete');

// Operational Bank Masuk
Route::get('/bank', 'App\Http\Controllers\FTransaksi\BankController@index')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('bank');
Route::post('/bank/store', 'App\Http\Controllers\FTransaksi\BankController@store')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('bank/store');
Route::get('/rbank', 'App\Http\Controllers\FReport\RBankController@report')->middleware(['auth'])->name('rbank');
    // GET BANK
    Route::get('/get-bank', 'App\Http\Controllers\FTransaksi\BankController@getBank')->middleware(['auth'])->name('get-bank');
    Route::get('/get-bank-report', 'App\Http\Controllers\FReport\RBankController@getBankReport')->middleware(['auth'])->name('get-bank-report');
    Route::post('rbank/jasper-bank-report', 'App\Http\Controllers\FReport\RBankController@jasperBankReport')->middleware(['auth']);
    Route::get('/jasper-bank-trans/{bank:NO_ID}', 'App\Http\Controllers\FTransaksi\BankController@jasperBankTrans')->middleware(['auth']);
// Dynamic Bank Masuk
Route::get('/bank/edit', 'App\Http\Controllers\FTransaksi\BankController@edit')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('bank.edit');
Route::post('/bank/update/{bank}', 'App\Http\Controllers\FTransaksi\BankController@update')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('bank.update');
Route::get('/bank/delete/{bank}', 'App\Http\Controllers\FTransaksi\BankController@destroy')->middleware(['auth'])->middleware(['checkDivisi:programmer,owner,assistant,accounting'])->name('bank.delete');


// Laporan Buku Besar
Route::get('/rbuku', 'App\Http\Controllers\FReport\RBukuController@report')->middleware(['auth']);
Route::get('/get-buku-report', 'App\Http\Controllers\FReport\RBukuController@getBukuReport')->middleware(['auth']);
Route::post('rbuku/jasper-buku-report', 'App\Http\Controllers\FReport\RBukuController@jasperBukuReport')->middleware(['auth']);


require __DIR__.'/auth.php';