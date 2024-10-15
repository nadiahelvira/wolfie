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



// Master Brg 
Route::get('/brg', 'App\Http\Controllers\Master\BrgController@index')->middleware(['auth'])->name('brg');
Route::post('/brg/store', 'App\Http\Controllers\Master\BrgController@store')->middleware(['auth'])->name('brg/store');
Route::get('/rbrg', 'App\Http\Controllers\OReport\RBrgController@report')->middleware(['auth'])->name('rbrg');
    // GET brg
    Route::get('/get-brg', 'App\Http\Controllers\Master\BrgController@getBrg')->middleware(['auth'])->name('get-brg');
    Route::get('/brg/browse', 'App\Http\Controllers\Master\BrgController@browse')->middleware(['auth'])->name('brg/browse');
    Route::get('/get-brg-report', 'App\Http\Controllers\OReport\RBrgController@getBrgReport')->middleware(['auth'])->name('get-brg-report');
    Route::post('/jasper-brg-report', 'App\Http\Controllers\OReport\RBrgController@jasperBrgReport')->middleware(['auth'])->name('jasper-brg-report');
    Route::get('brg/cekbrg', 'App\Http\Controllers\Master\BrgController@cekbrg')->middleware(['auth']);
	Route::get('brg/get-select-kd_brg', 'App\Http\Controllers\Master\BrgController@getSelectKdbrg')->middleware(['auth']);

// Dynamic Brg

Route::get('/brg/edit', 'App\Http\Controllers\Master\BrgController@edit')->middleware(['auth'])->name('brg.edit');
Route::post('/brg/update/{brg}', 'App\Http\Controllers\Master\BrgController@update')->middleware(['auth'])->name('brg.update');
Route::get('/brg/delete/{brg}', 'App\Http\Controllers\Master\BrgController@destroy')->middleware(['auth'])->name('brg.delete');


// Laporan Kartu Stok
Route::get('/rkarstk', 'App\Http\Controllers\OReport\RKarstkController@kartu')->middleware(['auth']);
Route::get('/get-stok-kartu', 'App\Http\Controllers\OReport\RKarstkController@getStokKartu')->middleware(['auth']);
Route::post('jasper-stok-kartu', 'App\Http\Controllers\OReport\RKarstkController@jasperStokKartu')->middleware(['auth']);



// Master Suplier 
Route::get('/sup', 'App\Http\Controllers\Master\SupController@index')->middleware(['auth'])->name('sup');
Route::post('/sup/store', 'App\Http\Controllers\Master\SupController@store')->middleware(['auth'])->name('sup/store');
Route::get('/rsup', 'App\Http\Controllers\OReport\RSupController@report')->middleware(['auth'])->name('rsup');
    // GET SUP
    Route::get('/get-sup', 'App\Http\Controllers\Master\SupController@getSup')->middleware(['auth'])->name('get-sup');
    Route::get('/sup/browse', 'App\Http\Controllers\Master\SupController@browse')->middleware(['auth'])->name('sup/browse');

    Route::get('/sup/browse', 'App\Http\Controllers\Master\SupController@browse')->middleware(['auth'])->name('sup/browse');
    Route::get('/sup/browsesupz', 'App\Http\Controllers\Master\SupController@browsesupz')->middleware(['auth'])->name('sup/browsesupz');
  

    Route::get('/get-sup-report', 'App\Http\Controllers\OReport\RSupController@getSupReport')->middleware(['auth'])->name('get-sup-report');
    Route::post('/jasper-sup-report', 'App\Http\Controllers\OReport\RSupController@jasperSupReport')->middleware(['auth'])->name('jasper-sup-report');
    Route::get('sup/ceksup', 'App\Http\Controllers\Master\SupController@ceksup_non')->middleware(['auth']);
	Route::get('sup/get-select-kodes', 'App\Http\Controllers\Master\SupController@getSelectKodes')->middleware(['auth']);
// Dynamic Suplier
Route::get('/sup/edit', 'App\Http\Controllers\Master\SupController@edit')->middleware(['auth'])->name('sup.edit');
Route::post('/sup/update/{sup}', 'App\Http\Controllers\Master\SupController@update')->middleware(['auth'])->name('sup.update');
Route::get('/sup/delete/{sup}', 'App\Http\Controllers\Master\SupController@destroy')->middleware(['auth'])->name('sup.delete');


// Laporan Kartu Hutang
Route::get('/rkartuh', 'App\Http\Controllers\OReport\RKartuhController@kartu')->middleware(['auth']);
Route::post('jasper-hut-kartu', 'App\Http\Controllers\OReport\RKartuhController@jasperHutKartu')->middleware(['auth']);

// Laporan Sisa Hutang
Route::get('/rsisa_hut', 'App\Http\Controllers\OReport\RKartuhController@sisa')->middleware(['auth']);
Route::post('/jasper-hut-sisa-report', 'App\Http\Controllers\OReport\RKartuhController@jasperHutSisaReport')->middleware(['auth']);




Route::get('/cust', 'App\Http\Controllers\Master\CustController@index')->middleware(['auth'])->name('cust');
Route::post('/cust/store', 'App\Http\Controllers\Master\CustController@store')->middleware(['auth'])->name('cust/store');
Route::get('/rcust', 'App\Http\Controllers\OReport\RcustController@report')->middleware(['auth'])->name('rcust');

    // GET cust
    Route::get('/get-cust', 'App\Http\Controllers\Master\CustController@getcust')->middleware(['auth'])->name('get-cust');
    Route::get('/cust/browse', 'App\Http\Controllers\Master\CustController@browse')->middleware(['auth'])->name('cust/browse');
    Route::get('/get-cust-report', 'App\Http\Controllers\OReport\RcustController@getcustReport')->middleware(['auth'])->name('get-cust-report');
    Route::post('/jasper-cust-report', 'App\Http\Controllers\OReport\RcustController@jaspercustReport')->middleware(['auth'])->name('jasper-cust-report');
    Route::get('cust/cekcust', 'App\Http\Controllers\Master\CustController@cekcust')->middleware(['auth']);
	Route::get('cust/get-select-kodec', 'App\Http\Controllers\Master\CustController@getSelectKodes')->middleware(['auth']);

// Dynamic cust
Route::get('/cust/edit', 'App\Http\Controllers\Master\CustController@edit')->middleware(['auth'])->name('cust.edit');
Route::post('/cust/update/{cust}', 'App\Http\Controllers\Master\CustController@update')->middleware(['auth'])->name('cust.update');
Route::get('/cust/delete/{cust}', 'App\Http\Controllers\Master\CustController@destroy')->middleware(['auth'])->name('cust.delete');


// Laporan Kartu Piutang
Route::get('/rkartup', 'App\Http\Controllers\OReport\RKartupController@kartu')->middleware(['auth']);
Route::post('jasper-piu-kartu', 'App\Http\Controllers\OReport\RKartupController@jasperPiuKartu')->middleware(['auth']);

// Laporan Sisa Piutang
Route::get('/rsisa_piu', 'App\Http\Controllers\OReport\RKartupController@sisa')->middleware(['auth']);
Route::post('/jasper-piu-sisa-report', 'App\Http\Controllers\OReport\RKartupController@jasperPiuSisaReport')->middleware(['auth']);



// Operational Jual

Route::get('/jual', 'App\Http\Controllers\OTransaksi\JualController@index')->middleware(['auth'])->name('jual');
Route::post('/jual/store', 'App\Http\Controllers\OTransaksi\JualController@store')->middleware(['auth'])->name('jual/store');
Route::get('/rjual', 'App\Http\Controllers\OReport\RJualController@report')->middleware(['auth'])->name('rjual');
    // GET BELI
    Route::get('/jual/browse', 'App\Http\Controllers\OTransaksi\JualController@browse')->middleware(['auth'])->name('jual/browse');
    Route::get('/jual/browseuang', 'App\Http\Controllers\OTransaksi\JualController@browseuang')->middleware(['auth'])->name('jual/browseuang');
    Route::get('/get-jual', 'App\Http\Controllers\OTransaksi\JualController@getJual')->middleware(['auth'])->name('get-jual');
	
    Route::get('/get-jual-post', 'App\Http\Controllers\OTransaksi\JualController@getJual_posting')->middleware(['auth'])->name('get-jual-post');
	
    Route::get('/get-jual-report', 'App\Http\Controllers\OReport\RJualController@getJualReport')->middleware(['auth'])->name('get-jual-report');
    Route::get('/jsjualc/{jual:NO_ID}', 'App\Http\Controllers\OTransaksi\JualController@jsjualc')->middleware(['auth']);
    Route::post('jasper-jual-report', 'App\Http\Controllers\OReport\RJualController@jasperJualReport')->middleware(['auth']);

    Route::get('/jual/browse_juald', 'App\Http\Controllers\OTransaksi\JualController@browse_juald')->middleware(['auth'])->name('jual/browse_juald');
	
// Dynamic Jual
Route::get('/jual/edit', 'App\Http\Controllers\OTransaksi\JualController@edit')->middleware(['auth'])->name('jual.edit');
Route::post('/jual/update/{jual}', 'App\Http\Controllers\OTransaksi\JualController@update')->middleware(['auth'])->name('jual.update');
Route::get('/jual/delete/{jual}', 'App\Http\Controllers\OTransaksi\JualController@destroy')->middleware(['auth'])->name('jual.delete');
Route::get('/jual/repost/{jual}', 'App\Http\Controllers\OTransaksi\JualController@repost')->middleware(['auth'])->name('jual.repost');

Route::post('jual/posting', 'App\Http\Controllers\OTransaksi\JualController@posting')->middleware(['auth']);
Route::get('jual/index-posting', 'App\Http\Controllers\OTransaksi\JualController@index_posting')->middleware(['auth']);

////////////////////////////////////////////////////////////

// Operational Koreksi Stock 

Route::get('/stock', 'App\Http\Controllers\OTransaksi\StockController@index')->middleware(['auth'])->name('stock');
Route::post('/stock/store', 'App\Http\Controllers\OTransaksi\StockController@store')->middleware(['auth'])->name('stock/store');
Route::get('/rstock', 'App\Http\Controllers\OReport\RStockController@report')->middleware(['auth'])->name('rstock');
    // GET BELI
    Route::get('/stock/browse', 'App\Http\Controllers\OTransaksi\StockController@browse')->middleware(['auth'])->name('stock/browse');
    Route::get('/get-stock', 'App\Http\Controllers\OTransaksi\StockController@getStock')->middleware(['auth'])->name('get-stock');
	

    Route::get('/get-stock-report', 'App\Http\Controllers\OReport\RStockController@getStockbReport')->middleware(['auth'])->name('get-stock-report');
    Route::get('/jsstockc/{stock:NO_ID}', 'App\Http\Controllers\OTransaksi\StockController@jsstockc')->middleware(['auth']);
    Route::post('jasper-stock-report', 'App\Http\Controllers\OReport\RStockController@jasperStockReport')->middleware(['auth']);

    Route::get('/stock/browse_stockd', 'App\Http\Controllers\OTransaksi\StockController@browse_stockd')->middleware(['auth'])->name('stock/browse_stockd');
	
Route::get('/stock/edit', 'App\Http\Controllers\OTransaksi\StockController@edit')->middleware(['auth'])->name('stock.edit');
Route::post('/stock/update/{stock}', 'App\Http\Controllers\OTransaksi\StockController@update')->middleware(['auth'])->name('stock.update');
Route::get('/stock/delete/{stock}', 'App\Http\Controllers\OTransaksi\StockController@destroy')->middleware(['auth'])->name('stock.delete');


	


// Operational Beli
Route::get('/beli', 'App\Http\Controllers\OTransaksi\BeliController@index')->middleware(['auth'])->name('beli');
Route::post('/beli/store', 'App\Http\Controllers\OTransaksi\BeliController@store')->middleware(['auth'])->name('beli/store');
Route::get('/rbeli', 'App\Http\Controllers\OReport\RBeliController@report')->middleware(['auth'])->name('rbeli');
    // GET BELI
    Route::get('/beli/browse', 'App\Http\Controllers\OTransaksi\BeliController@browse')->middleware(['auth'])->name('beli/browse');
    Route::get('/beli/browse_detail', 'App\Http\Controllers\OTransaksi\BeliController@browse_detail')->middleware(['auth'])->name('beli/browse_detail');
   
    Route::get('/beli/browseuang', 'App\Http\Controllers\OTransaksi\BeliController@browseuang')->middleware(['auth'])->name('beli/browseuang');
    Route::get('/get-beli', 'App\Http\Controllers\OTransaksi\BeliController@getBeli')->middleware(['auth'])->name('get-beli');
	
    Route::get('/get-beli-post', 'App\Http\Controllers\OTransaksi\BeliController@getBeli_posting')->middleware(['auth'])->name('get-beli-post');
	
    Route::get('/get-beli-report', 'App\Http\Controllers\OReport\RBeliController@getBeliReport')->middleware(['auth'])->name('get-beli-report');
    Route::get('/jsbelic/{beli:NO_ID}', 'App\Http\Controllers\OTransaksi\BeliController@jsbelic')->middleware(['auth']);
    Route::post('jasper-beli-report', 'App\Http\Controllers\OReport\RBeliController@jasperBeliReport')->middleware(['auth']);

    Route::get('/beli/browse_belid', 'App\Http\Controllers\OTransaksi\BeliController@browse_belid')->middleware(['auth'])->name('beli/browse_belid');
	
// Dynamic Beli_non
Route::get('/beli/edit', 'App\Http\Controllers\OTransaksi\BeliController@edit')->middleware(['auth'])->name('beli.edit');
Route::post('/beli/update/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@update')->middleware(['auth'])->name('beli.update');
Route::get('/beli/delete/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@destroy')->middleware(['auth'])->name('beli.delete');
Route::get('/beli/repost/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@repost')->middleware(['auth'])->name('beli.repost');

Route::post('beli/posting', 'App\Http\Controllers\OTransaksi\BeliController@posting')->middleware(['auth']);
Route::get('beli/index-posting', 'App\Http\Controllers\OTransaksi\BeliController@index_posting')->middleware(['auth']);




// po



Route::get('/po', 'App\Http\Controllers\OTransaksi\PoController@index')->middleware(['auth'])->name('po');
Route::post('/po/store', 'App\Http\Controllers\OTransaksi\PoController@store')->middleware(['auth'])->name('po/store');
Route::get('/rpo', 'App\Http\Controllers\OReport\RPoController@report')->middleware(['auth'])->name('rpo');
    // GET BELI
    Route::get('/po/browse', 'App\Http\Controllers\OTransaksi\PoController@browse')->middleware(['auth'])->name('po/browse');
    Route::get('/po/browse_detail', 'App\Http\Controllers\OTransaksi\PoController@browse_detail')->middleware(['auth'])->name('po/browse_detail');
   
    Route::get('/get-po', 'App\Http\Controllers\OTransaksi\PoController@getPo')->middleware(['auth'])->name('get-po');
	
    Route::get('/get-po-post', 'App\Http\Controllers\OTransaksi\PoController@getPo_posting')->middleware(['auth'])->name('get-po-post');
	
    Route::get('/get-po-report', 'App\Http\Controllers\OReport\RPoController@getPoReport')->middleware(['auth'])->name('get-po-report');
    Route::get('/jspoc/{po:NO_ID}', 'App\Http\Controllers\OTransaksi\PoController@jspoc')->middleware(['auth']);
    Route::post('jasper-po-report', 'App\Http\Controllers\OReport\RPoController@jasperPoReport')->middleware(['auth']);

    Route::get('/po/browse_pod', 'App\Http\Controllers\OTransaksi\PoController@browse_pod')->middleware(['auth'])->name('po/browse_pod');
	
// Dynamic Beli_non
Route::get('/po/edit', 'App\Http\Controllers\OTransaksi\PoController@edit')->middleware(['auth'])->name('po.edit');
Route::post('/po/update/{po}', 'App\Http\Controllers\OTransaksi\PoController@update')->middleware(['auth'])->name('po.update');
Route::get('/po/delete/{po}', 'App\Http\Controllers\OTransaksi\PoController@destroy')->middleware(['auth'])->name('po.delete');
Route::get('/po/repost/{po}', 'App\Http\Controllers\OTransaksi\PoController@repost')->middleware(['auth'])->name('po.repost');

Route::post('po/posting', 'App\Http\Controllers\OTransaksi\PoController@posting')->middleware(['auth']);
Route::get('po/index-posting', 'App\Http\Controllers\OTransaksi\PoController@index_posting')->middleware(['auth']);


/// so

Route::get('/so', 'App\Http\Controllers\OTransaksi\SoController@index')->middleware(['auth'])->name('so');
Route::post('/so/store', 'App\Http\Controllers\OTransaksi\SoController@store')->middleware(['auth'])->name('so/store');
Route::get('/rso', 'App\Http\Controllers\OReport\RSoController@report')->middleware(['auth'])->name('rso');
    // GET BELI
    Route::get('/so/browse', 'App\Http\Controllers\OTransaksi\SoController@browse')->middleware(['auth'])->name('so/browse');
    Route::get('/so/browse_detail', 'App\Http\Controllers\OTransaksi\SoController@browse_detail')->middleware(['auth'])->name('so/browse_detail');
       Route::get('/get-so', 'App\Http\Controllers\OTransaksi\SoController@getSo')->middleware(['auth'])->name('get-so');
	
    Route::get('/get-so-post', 'App\Http\Controllers\OTransaksi\SoController@getSo_posting')->middleware(['auth'])->name('get-so-post');
	
    Route::get('/get-so-report', 'App\Http\Controllers\OReport\RSoController@getSoReport')->middleware(['auth'])->name('get-so-report');
    Route::get('/jssoc/{so:NO_ID}', 'App\Http\Controllers\OTransaksi\SoController@jssoc')->middleware(['auth']);
    Route::post('jasper-so-report', 'App\Http\Controllers\OReport\RSoController@jasperSoReport')->middleware(['auth']);

    Route::get('/so/browse_sod', 'App\Http\Controllers\OTransaksi\SoController@browse_belid')->middleware(['auth'])->name('beli/browse_belid');
	

Route::get('/so/edit', 'App\Http\Controllers\OTransaksi\SoController@edit')->middleware(['auth'])->name('so.edit');
Route::post('/so/update/{so}', 'App\Http\Controllers\OTransaksi\SoController@update')->middleware(['auth'])->name('so.update');
Route::get('/so/delete/{so}', 'App\Http\Controllers\OTransaksi\SoController@destroy')->middleware(['auth'])->name('so.delete');
Route::get('/so/repost/{so}', 'App\Http\Controllers\OTransaksi\SoController@repost')->middleware(['auth'])->name('so.repost');

Route::post('so/posting', 'App\Http\Controllers\OTransaksi\SoController@posting')->middleware(['auth']);
Route::get('so/index-posting', 'App\Http\Controllers\OTransaksi\SoController@index_posting')->middleware(['auth']);

	
/// hut

Route::get('/hut', 'App\Http\Controllers\OTransaksi\HutController@index')->middleware(['auth'])->name('hut');
Route::post('/hut/store', 'App\Http\Controllers\OTransaksi\HutController@store')->middleware(['auth'])->name('hut/store');

Route::get('/rhut', 'App\Http\Controllers\OReport\RHutController@report')->middleware(['auth'])->name('rhut');
    // GET HUT
    Route::get('/get-hut', 'App\Http\Controllers\OTransaksi\HutController@getHut')->middleware(['auth'])->name('get-hut');
		
    Route::get('/get-hut-post', 'App\Http\Controllers\OTransaksi\HutController@getHut_posting')->middleware(['auth'])->name('get-hut-post');
		
    Route::get('/hut/print/{hut:NO_ID}', 'App\Http\Controllers\OTransaksi\HutController@cetak')->middleware(['auth']);
    Route::get('/get-hut-report', 'App\Http\Controllers\OReport\RHutController@getHutReport')->middleware(['auth'])->name('get-hut-report');
    Route::post('/jasper-hut-report', 'App\Http\Controllers\OReport\RHutController@jasperHutReport')->middleware(['auth']);
// Dynamic Hut
Route::get('/hut/edit', 'App\Http\Controllers\OTransaksi\HutController@edit')->middleware(['auth'])->name('hut.edit');
Route::post('/hut/update/{hut}', 'App\Http\Controllers\OTransaksi\HutController@update')->middleware(['auth'])->name('hut.update');
Route::get('/hut/delete/{hut}', 'App\Http\Controllers\OTransaksi\HutController@destroy')->middleware(['auth'])->name('hut.delete');

Route::post('hut/posting', 'App\Http\Controllers\OTransaksi\HutController@posting')->middleware(['auth']);
Route::get('hut/index-posting', 'App\Http\Controllers\OTransaksi\HutController@index_posting')->middleware(['auth']);
Route::get('/hut/browse_hutd', 'App\Http\Controllers\OTransaksi\HutController@browse_hutd')->middleware(['auth'])->name('hut/browse_hutd');
	
	
//  // piu

Route::get('/piu', 'App\Http\Controllers\OTransaksi\PiuController@index')->middleware(['auth'])->name('piu');
Route::post('/piu/store', 'App\Http\Controllers\OTransaksi\PiuController@store')->middleware(['auth'])->name('piu/store');

Route::get('/rpiu', 'App\Http\Controllers\OReport\RPiuController@report')->middleware(['auth'])->name('rpiu');
    // GET HUT
    Route::get('/get-piu', 'App\Http\Controllers\OTransaksi\PiuController@getPiu')->middleware(['auth'])->name('get-piu');
		
    Route::get('/get-piu-post', 'App\Http\Controllers\OTransaksi\PiuController@getHut_posting')->middleware(['auth'])->name('get-piu-post');
		
    Route::get('/hut/print/{hut:NO_ID}', 'App\Http\Controllers\OTransaksi\PiuController@cetak')->middleware(['auth']);
    Route::get('/get-piu-report', 'App\Http\Controllers\OReport\RPiuController@getPiuReport')->middleware(['auth'])->name('get-piu-report');
    Route::post('/jasper-piu-report', 'App\Http\Controllers\OReport\RPiuController@jasperPiuReport')->middleware(['auth']);
// Dynamic Hut
Route::get('/piu/edit', 'App\Http\Controllers\OTransaksi\PiuController@edit')->middleware(['auth'])->name('piu.edit');
Route::post('/piu/update/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@update')->middleware(['auth'])->name('piu.update');
Route::get('/piu/delete/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@destroy')->middleware(['auth'])->name('piu.delete');

Route::post('piu/posting', 'App\Http\Controllers\OTransaksi\PiuController@posting')->middleware(['auth']);
Route::get('piu/index-posting', 'App\Http\Controllers\OTransaksi\PiuController@index_posting')->middleware(['auth']);
Route::get('/piu/browse_piud', 'App\Http\Controllers\OTransaksi\PiuController@browse_piud')->middleware(['auth'])->name('piu/browse_hutd');
	











require __DIR__.'/auth.php';