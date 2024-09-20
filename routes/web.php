<?php

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

// Dashboard
Route::get('/', 'App\Http\Controllers\DashboardController@index')->middleware(['auth']);
Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth']);
// Chart Dashboard
Route::get('/chart', 'App\Http\Controllers\DashboardController@chart')->middleware(['auth']);

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Static Route

// Periode
Route::post('/periode', 'App\Http\Controllers\PeriodeController@index')->middleware(['auth'])->name('periode');

// Master Account
Route::get('/account', 'App\Http\Controllers\FMaster\AccountController@index')->middleware(['auth'])->name('account');

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
Route::get('/account/edit', 'App\Http\Controllers\FMaster\AccountController@edit')->middleware(['auth'])->name('account.edit');
Route::post('/account/update/{account}', 'App\Http\Controllers\FMaster\AccountController@update')->middleware(['auth'])->name('account.update');
Route::get('/account/delete/{account}', 'App\Http\Controllers\FMaster\AccountController@destroy')->middleware(['auth'])->name('account.delete');

Route::get('/rrl', 'App\Http\Controllers\FReport\RRlController@report')->middleware(['auth'])->name('rrl');
Route::get('/get-rl-report', 'App\Http\Controllers\FReport\RRlController@getRlReport')->middleware(['auth'])->name('get-rl-report');
Route::post('/jasper-rl-report', 'App\Http\Controllers\FReport\RRlController@jasperRlReport')->middleware(['auth']);

Route::get('/rnera', 'App\Http\Controllers\FReport\RNeraController@report')->middleware(['auth'])->name('rnera');
Route::get('/get-nera-report', 'App\Http\Controllers\FReport\RNeraController@getNeraReport')->middleware(['auth'])->name('get-nera-report');
Route::post('/jasper-nera-report', 'App\Http\Controllers\FReport\RNeraController@jasperNeraReport')->middleware(['auth']);




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
    Route::get('sup/ceksup', 'App\Http\Controllers\Master\SupController@ceksup')->middleware(['auth']);
	Route::get('sup/get-select-kodes', 'App\Http\Controllers\Master\SupController@getSelectKodes')->middleware(['auth']);
// Dynamic Suplier
Route::get('/sup/edit', 'App\Http\Controllers\Master\SupController@edit')->middleware(['auth'])->name('sup.edit');
Route::post('/sup/update/{sup}', 'App\Http\Controllers\Master\SupController@update')->middleware(['auth'])->name('sup.update');
Route::get('/sup/delete/{sup}', 'App\Http\Controllers\Master\SupController@destroy')->middleware(['auth'])->name('sup.delete');


//////////////////////



// Master Bhn 
Route::get('/bhn', 'App\Http\Controllers\Master\BhnController@index')->middleware(['auth'])->name('bhn');
Route::post('/bhn/store', 'App\Http\Controllers\Master\BhnController@store')->middleware(['auth'])->name('bhn/store');
Route::get('/rbhn', 'App\Http\Controllers\OReport\RBhnController@report')->middleware(['auth'])->name('rbhn');
    // GET bhn
    Route::get('/get-bhn', 'App\Http\Controllers\Master\BhnController@getBhn')->middleware(['auth'])->name('get-bhn');
    Route::get('/bhn/browse', 'App\Http\Controllers\Master\BhnController@browse')->middleware(['auth'])->name('bhn/browse');
    Route::get('/bhn/browseall', 'App\Http\Controllers\Master\BhnController@browseall')->middleware(['auth'])->name('bhn/browseall');
    Route::get('/get-bhn-report', 'App\Http\Controllers\OReport\RBhnController@getBhnReport')->middleware(['auth'])->name('get-bhn-report');
    Route::post('/jasper-bhn-report', 'App\Http\Controllers\OReport\RBhnController@jasperBhnReport')->middleware(['auth'])->name('jasper-bhn-report');
    Route::get('bhn/cekbhn', 'App\Http\Controllers\Master\BhnController@cekbhn')->middleware(['auth']);
	Route::get('bhn/get-select-kd_bhn', 'App\Http\Controllers\Master\BhnController@getSelectKdbhn')->middleware(['auth']);

// Dynamic Bhn

Route::get('/bhn/edit', 'App\Http\Controllers\Master\BhnController@edit')->middleware(['auth'])->name('bhn.edit');
Route::post('/bhn/update/{bhn}', 'App\Http\Controllers\Master\BhnController@update')->middleware(['auth'])->name('bhn.update');
Route::get('/bhn/delete/{bhn}', 'App\Http\Controllers\Master\BhnController@destroy')->middleware(['auth'])->name('bhn.delete');


///////////////////////
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

// master cust

Route::get('/cust', 'App\Http\Controllers\Master\CustController@index')->middleware(['auth'])->name('cust');
Route::post('/cust/store', 'App\Http\Controllers\Master\CustController@store')->middleware(['auth'])->name('cust/store');
Route::get('/rcust', 'App\Http\Controllers\OReport\RCustController@report')->middleware(['auth'])->name('rcust');

    // GET cust
    Route::get('/get-cust', 'App\Http\Controllers\Master\CustController@getcust')->middleware(['auth'])->name('get-cust');
    Route::get('/cust/browse', 'App\Http\Controllers\Master\CustController@browse')->middleware(['auth'])->name('cust/browse');
    Route::get('/get-cust-report', 'App\Http\Controllers\OReport\RcustController@getcustReport')->middleware(['auth'])->name('get-cust-report');
    Route::post('/jasper-cust-report', 'App\Http\Controllers\OReport\RCustController@jaspercustReport')->middleware(['auth'])->name('jasper-cust-report');
    Route::get('cust/cekcust', 'App\Http\Controllers\Master\CustController@cekcust')->middleware(['auth']);
	Route::get('cust/get-select-kodec', 'App\Http\Controllers\Master\CustController@getSelectKodes')->middleware(['auth']);

// Dynamic cust
Route::get('/cust/edit', 'App\Http\Controllers\Master\CustController@edit')->middleware(['auth'])->name('cust.edit');
Route::post('/cust/update/{cust}', 'App\Http\Controllers\Master\CustController@update')->middleware(['auth'])->name('cust.update');
Route::get('/cust/delete/{cust}', 'App\Http\Controllers\Master\CustController@destroy')->middleware(['auth'])->name('cust.delete');


// Master Fo

Route::get('/fo', 'App\Http\Controllers\Master\FoController@index')->middleware(['auth'])->name('fo');
Route::post('/fo/store', 'App\Http\Controllers\Master\FoController@store')->middleware(['auth'])->name('fo/store');
Route::get('/rfo', 'App\Http\Controllers\OReport\RFoController@report')->middleware(['auth'])->name('rfo');

    // GET Fo
    Route::get('/fo/browse', 'App\Http\Controllers\Master\FoController@browse')->middleware(['auth'])->name('fo/browse');
    Route::get('/fo/browse_detail', 'App\Http\Controllers\Master\FoController@browse_detail')->middleware(['auth'])->name('fo/browse_detail');
   
    Route::get('/get-fo', 'App\Http\Controllers\Master\FoController@getFo')->middleware(['auth'])->name('get-fo');
	
    Route::get('/get-fo-post', 'App\Http\Controllers\Master\FoController@getFo_posting')->middleware(['auth'])->name('get-fo-post');
	
    Route::get('/get-fo-report', 'App\Http\Controllers\OReport\RFoController@getFoReport')->middleware(['auth'])->name('get-fo-report');
    Route::get('/jspoc/{fo:NO_ID}', 'App\Http\Controllers\Master\FoController@jspoc')->middleware(['auth']);
    Route::post('jasper-fo-report', 'App\Http\Controllers\OReport\RFoController@jasperFoReport')->middleware(['auth']);

    Route::get('/fo/browse_pod', 'App\Http\Controllers\Master\FoController@browse_pod')->middleware(['auth'])->name('fo/browse_pod');
	
// Dynamic Fo
Route::get('/fo/edit', 'App\Http\Controllers\Master\FoController@edit')->middleware(['auth'])->name('fo.edit');
Route::post('/fo/update/{fo}', 'App\Http\Controllers\Master\FoController@update')->middleware(['auth'])->name('fo.update');
Route::get('/fo/delete/{fo}', 'App\Http\Controllers\Master\FoController@destroy')->middleware(['auth'])->name('fo.delete');
Route::get('/fo/repost/{fo}', 'App\Http\Controllers\Master\FoController@repost')->middleware(['auth'])->name('fo.repost');

Route::post('fo/posting', 'App\Http\Controllers\Master\FoController@posting')->middleware(['auth']);
Route::get('fo/index-posting', 'App\Http\Controllers\Master\FoController@index_posting')->middleware(['auth']);


// Master Formula Urut
Route::get('/fourut', 'App\Http\Controllers\Master\FoUrutController@index')->middleware(['auth'])->name('fourut');
Route::post('/fourut/store', 'App\Http\Controllers\Master\FoUrutController@store')->middleware(['auth'])->name('fourut/store');
Route::get('/get-fourut', 'App\Http\Controllers\Master\FoUrutController@getFourut')->middleware(['auth'])->name('get-fourut');
Route::get('/fourut/show/{fo}', 'App\Http\Controllers\Master\FoUrutController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('fourutid');
Route::get('/fourut/edit/{fo}', 'App\Http\Controllers\Master\FoUrutController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('fourut.edit');
Route::post('/fourut/update/{fo}', 'App\Http\Controllers\Master\FoUrutController@update')->middleware(['auth', 'role:superadmin|operational'])->name('fourut.update');


// Master Proses
Route::get('/prs', 'App\Http\Controllers\Master\PrsController@index')->middleware(['auth'])->name('prs');
Route::post('/prs/store', 'App\Http\Controllers\Master\PrsController@store')->middleware(['auth'])->name('prs/store');
Route::get('/prs/create', 'App\Http\Controllers\Master\PrsController@create')->middleware(['auth'])->name('prs/create');
Route::get('/get-prs', 'App\Http\Controllers\Master\PrsController@getPrs')->middleware(['auth'])->name('get-prs');
Route::get('/prs/browses', 'App\Http\Controllers\Master\PrsController@browses')->middleware(['auth'])->name('prs/browses');
Route::get('/prs/browseb', 'App\Http\Controllers\Master\PrsController@browseb')->middleware(['auth'])->name('prs/browseb');
Route::get('/prs/browseall', 'App\Http\Controllers\Master\PrsController@browseall')->middleware(['auth'])->name('prs/browseall');
Route::get('/rprs', 'App\Http\Controllers\OReport\RPrsController@report')->middleware(['auth'])->name('rprs');
Route::get('/get-prs-report', 'App\Http\Controllers\OReport\RPrsController@getPrsReport')->middleware(['auth'])->name('get-prs-report');


// Manage User
Route::get('/user/manage', 'App\Http\Controllers\UserController@index')->middleware(['auth', 'role:superadmin'])->name('user/manage');
Route::get('/user/add', 'App\Http\Controllers\UserController@create')->middleware(['auth', 'role:user|superadmin'])->name('user/add');
Route::get('/get-user', 'App\Http\Controllers\UserController@getUser')->middleware(['auth', 'role:user|superadmin'])->name('get-user');
Route::post('/user/add', 'App\Http\Controllers\UserController@store')->middleware(['auth', 'role:user|superadmin'])->name('user/add');


// Operational PO

Route::get('/po', 'App\Http\Controllers\OTransaksi\PoController@index')->middleware(['auth'])->name('po');
Route::post('/po/store', 'App\Http\Controllers\OTransaksi\PoController@store')->middleware(['auth'])->name('po/store');
Route::get('/rpo', 'App\Http\Controllers\OReport\RPoController@report')->middleware(['auth'])->name('rpo');
    // GET BELI
    Route::get('/po/browse', 'App\Http\Controllers\OTransaksi\PoController@browse')->middleware(['auth'])->name('po/browse');
    Route::get('/po/browse_detail', 'App\Http\Controllers\OTransaksi\PoController@browse_detail')->middleware(['auth'])->name('po/browse_detail');
    Route::get('/po/browse_detail2', 'App\Http\Controllers\OTransaksi\PoController@browse_detail2')->middleware(['auth'])->name('po/browse_detail2');
    Route::get('/po/browse_pod', 'App\Http\Controllers\OTransaksi\PoController@browse_pod')->middleware(['auth'])->name('po/browse_pod');
    Route::get('/po/browseuang', 'App\Http\Controllers\OTransaksi\PoController@browseuang')->middleware(['auth'])->name('po/browseuang');
   
    Route::get('/get-po', 'App\Http\Controllers\OTransaksi\PoController@getPo')->middleware(['auth'])->name('get-po');
	
    Route::get('/get-po-post', 'App\Http\Controllers\OTransaksi\PoController@getPo_posting')->middleware(['auth'])->name('get-po-post');
	
    Route::get('/get-po-report', 'App\Http\Controllers\OReport\RPoController@getPoReport')->middleware(['auth'])->name('get-po-report');
    // Route::get('/cetak/{po:NO_ID}', 'App\Http\Controllers\OTransaksi\PoController@cetak')->middleware(['auth']);
	Route::get('/po/cetak/{po:NO_ID}','App\Http\Controllers\OTransaksi\PoController@cetak')->middleware(['auth']);
    
    Route::post('jasper-po-report', 'App\Http\Controllers\OReport\RPoController@jasperPoReport')->middleware(['auth']);

    Route::get('/po/browse_pod', 'App\Http\Controllers\OTransaksi\PoController@browse_pod')->middleware(['auth'])->name('po/browse_pod');
	
// Dynamic Po
Route::get('/po/edit', 'App\Http\Controllers\OTransaksi\PoController@edit')->middleware(['auth'])->name('po.edit');
Route::post('/po/update/{po}', 'App\Http\Controllers\OTransaksi\PoController@update')->middleware(['auth'])->name('po.update');
Route::get('/po/delete/{po}', 'App\Http\Controllers\OTransaksi\PoController@destroy')->middleware(['auth'])->name('po.delete');
Route::get('/po/repost/{po}', 'App\Http\Controllers\OTransaksi\PoController@repost')->middleware(['auth'])->name('po.repost');

Route::post('po/posting', 'App\Http\Controllers\OTransaksi\PoController@posting')->middleware(['auth']);
Route::get('po/index-posting', 'App\Http\Controllers\OTransaksi\PoController@index_posting')->middleware(['auth']);

// Posting
Route::get('/posting/index', 'App\Http\Controllers\PostingController@index')->middleware(['auth']);
Route::post('/posting/proses', 'App\Http\Controllers\PostingController@posting')->middleware(['auth']);


/// so

Route::get('/so', 'App\Http\Controllers\OTransaksi\SoController@index')->middleware(['auth'])->name('so');
Route::post('/so/store', 'App\Http\Controllers\OTransaksi\SoController@store')->middleware(['auth'])->name('so/store');
Route::get('/rso', 'App\Http\Controllers\OReport\RSoController@report')->middleware(['auth'])->name('rso');
    // GET SO
    Route::get('/so/browse', 'App\Http\Controllers\OTransaksi\SoController@browse')->middleware(['auth'])->name('so/browse');
    Route::get('/so/browse_detail', 'App\Http\Controllers\OTransaksi\SoController@browse_detail')->middleware(['auth'])->name('so/browse_detail');
    Route::get('/so/browse_detail2', 'App\Http\Controllers\OTransaksi\SoController@browse_detail2')->middleware(['auth'])->name('so/browse_detail2');
    Route::get('/so/browseuang', 'App\Http\Controllers\OTransaksi\SoController@browseuang')->middleware(['auth'])->name('so/browseuang');
       Route::get('/get-so', 'App\Http\Controllers\OTransaksi\SoController@getSo')->middleware(['auth'])->name('get-so');
	
    Route::get('/get-so-post', 'App\Http\Controllers\OTransaksi\SoController@getSo_posting')->middleware(['auth'])->name('get-so-post');
	
    Route::get('/get-so-report', 'App\Http\Controllers\OReport\RSoController@getSoReport')->middleware(['auth'])->name('get-so-report');
    Route::get('/jssoc/{so:NO_ID}', 'App\Http\Controllers\OTransaksi\SoController@jssoc')->middleware(['auth']);
    Route::post('jasper-so-report', 'App\Http\Controllers\OReport\RSoController@jasperSoReport')->middleware(['auth']);

    Route::get('/so/browse_sod', 'App\Http\Controllers\OTransaksi\SoController@browse_sod')->middleware(['auth'])->name('so/browse_sod');
	

Route::get('/so/edit', 'App\Http\Controllers\OTransaksi\SoController@edit')->middleware(['auth'])->name('so.edit');
Route::post('/so/update/{so}', 'App\Http\Controllers\OTransaksi\SoController@update')->middleware(['auth'])->name('so.update');
Route::get('/so/delete/{so}', 'App\Http\Controllers\OTransaksi\SoController@destroy')->middleware(['auth'])->name('so.delete');
Route::get('/so/repost/{so}', 'App\Http\Controllers\OTransaksi\SoController@repost')->middleware(['auth'])->name('so.repost');

Route::post('so/posting', 'App\Http\Controllers\OTransaksi\SoController@posting')->middleware(['auth']);
Route::get('so/index-posting', 'App\Http\Controllers\OTransaksi\SoController@index_posting')->middleware(['auth']);

// Operational Transaksi Orderk
Route::get('/orderk', 'App\Http\Controllers\OTransaksi\OrderkController@index')->middleware(['auth'])->name('orderk');
Route::post('/orderk/store', 'App\Http\Controllers\OTransaksi\OrderkController@store')->middleware(['auth'])->name('orderk/store');
Route::get('/orderk/create', 'App\Http\Controllers\OTransaksi\OrderkController@create')->middleware(['auth'])->name('orderk/create');
Route::get('/get-orderk', 'App\Http\Controllers\OTransaksi\OrderkController@getOrderk')->middleware(['auth'])->name('get-orderk');
Route::get('/rorderk', 'App\Http\Controllers\OReport\ROrderkController@report')->middleware(['auth'])->name('rorderk');
Route::get('/get-orderk-report', 'App\Http\Controllers\OReport\ROderkController@getOrderkReport')->middleware(['auth'])->name('get-orderk-report');

Route::get('/orderk/show/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('orderkid');
Route::get('/orderk/edit', 'App\Http\Controllers\OTransaksi\OrderkController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('orderk.edit');
Route::post('/orderk/update/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@update')->middleware(['auth', 'role:superadmin|operational'])->name('orderk.update');
Route::get('/orderk/delete/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@destroy')->middleware(['auth', 'role:superadmin'])->name('orderk.delete');

Route::get('/orderk/browseSo', 'App\Http\Controllers\OTransaksi\OrderkController@browseSo')->middleware(['auth']);
Route::get('/orderk/browse_detail', 'App\Http\Controllers\OTransaksi\OrderkController@browse_detail')->middleware(['auth']);
Route::get('/orderk/browseFo', 'App\Http\Controllers\OTransaksi\OrderkController@browseFo')->middleware(['auth']);
Route::get('/orderk/browseFod', 'App\Http\Controllers\OTransaksi\OrderkController@browseFod')->middleware(['auth']);
Route::get('/orderk/browseFodPrs', 'App\Http\Controllers\OTransaksi\OrderkController@browseFodPrs')->middleware(['auth']);
Route::get('/orderk/browseOrderkxd', 'App\Http\Controllers\OTransaksi\OrderkController@browseOrderkxd')->middleware(['auth']);
Route::get('/orderk/browsePakai', 'App\Http\Controllers\OTransaksi\OrderkController@browsePakai')->middleware(['auth']);

Route::post('/jasper-orderk-report', 'App\Http\Controllers\OReport\ROrderkController@jasperOrderkReport')->middleware(['auth']);
Route::get('/jsorderkc/{orderk:NO_ID}', 'App\Http\Controllers\OTransaksi\OrderkController@jsorderkc')->middleware(['auth']);


// Operational Transaksi Pakai
Route::get('/pakai', 'App\Http\Controllers\OTransaksi\PakaiController@index')->middleware(['auth'])->name('pakai');
Route::post('/pakai/store', 'App\Http\Controllers\OTransaksi\PakaiController@store')->middleware(['auth'])->name('pakai/store');
Route::get('/pakai/create', 'App\Http\Controllers\OTransaksi\PakaiController@create')->middleware(['auth'])->name('pakai/create');
Route::get('/get-pakai', 'App\Http\Controllers\OTransaksi\PakaiController@getPakai')->middleware(['auth'])->name('get-pakai');
Route::get('/rpakai', 'App\Http\Controllers\OReport\RPakaiController@report')->middleware(['auth'])->name('rpakai');
Route::get('/get-pakai-report', 'App\Http\Controllers\OReport\RPakaiController@getPakaiReport')->middleware(['auth'])->name('get-pakai-report');

Route::get('/pakai/show/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('pakaiid');
Route::get('/pakai/edit', 'App\Http\Controllers\OTransaksi\PakaiController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pakai.edit');
Route::post('/pakai/update/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pakai.update');
Route::get('/pakai/delete/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@destroy')->middleware(['auth', 'role:superadmin'])->name('pakai.delete');

Route::get('/pakai/browseOk', 'App\Http\Controllers\OTransaksi\PakaiController@browseOk')->middleware(['auth']);
Route::get('/pakai/browsePrs', 'App\Http\Controllers\OTransaksi\PakaiController@browsePrs')->middleware(['auth']);
Route::get('/pakai/browseBhn', 'App\Http\Controllers\OTransaksi\PakaiController@browseBhn')->middleware(['auth']);
Route::get('/pakai/browseXd', 'App\Http\Controllers\OTransaksi\PakaiController@browseXd')->middleware(['auth']);
Route::get('/pakai/cekOrderkWIP', 'App\Http\Controllers\OTransaksi\PakaiController@cekOrderkWIP')->middleware(['auth']);

Route::post('/jasper-pakai-report', 'App\Http\Controllers\OReport\RPakaiController@jasperPakaiReport')->middleware(['auth']);
Route::get('/jspakaic/{pakai:NO_ID}', 'App\Http\Controllers\OTransaksi\PakaiController@jspakaic')->middleware(['auth']);


// Operational Terima
Route::get('/terima', 'App\Http\Controllers\OTransaksi\TerimaController@index')->middleware(['auth'])->name('terima');
Route::post('/terima/store', 'App\Http\Controllers\OTransaksi\TerimaController@store')->middleware(['auth'])->name('terima/store');
Route::get('/terima/create', 'App\Http\Controllers\OTransaksi\TerimaController@create')->middleware(['auth'])->name('terima/create');
Route::get('/get-terima', 'App\Http\Controllers\OTransaksi\TerimaController@getTerima')->middleware(['auth'])->name('get-terima');
Route::get('/rterima', 'App\Http\Controllers\OReport\RTerimaController@report')->middleware(['auth'])->name('rterima');
Route::get('/get-terima-report', 'App\Http\Controllers\OReport\RTerimaController@getTerimaReport')->middleware(['auth'])->name('get-terima-report');

Route::get('/terima/show/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('terimaid');
Route::get('/terima/edit', 'App\Http\Controllers\OTransaksi\TerimaController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('terima.edit');
Route::post('/terima/update/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@update')->middleware(['auth', 'role:superadmin|operational'])->name('terima.update');
Route::get('/terima/delete/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@destroy')->middleware(['auth', 'role:superadmin'])->name('terima.delete');

Route::get('/terima/browsePakai', 'App\Http\Controllers\OTransaksi\TerimaController@browsePakai')->middleware(['auth']);
Route::get('/terima/browsePakaid', 'App\Http\Controllers\OTransaksi\TerimaController@browsePakaid')->middleware(['auth']);

Route::post('/jasper-terima-report', 'App\Http\Controllers\OReport\RTerimaController@jasperTerimaReport')->middleware(['auth']);
Route::get('/jsterimac/{terima:NO_ID}', 'App\Http\Controllers\OTransaksi\TerimaController@jsterimac')->middleware(['auth']);


// Operational Stocka

Route::get('/stocka', 'App\Http\Controllers\OTransaksi\StockaController@index')->middleware(['auth'])->name('stocka');
Route::post('/stocka/store', 'App\Http\Controllers\OTransaksi\StockaController@store')->middleware(['auth'])->name('stocka/store');
Route::get('/rstocka', 'App\Http\Controllers\OReport\RStockaController@report')->middleware(['auth'])->name('rstocka');
    
// GET Stocka
    Route::get('/stocka/browse', 'App\Http\Controllers\OTransaksi\StockaController@browse')->middleware(['auth'])->name('stocka/browse');
    Route::get('/stocka/browse_detail', 'App\Http\Controllers\OTransaksi\StockaController@browse_detail')->middleware(['auth'])->name('stocka/browse_detail');
    Route::get('/stocka/browseuang', 'App\Http\Controllers\OTransaksi\StockaController@browseuang')->middleware(['auth'])->name('stocka/browseuang');
   
    Route::get('/get-stocka', 'App\Http\Controllers\OTransaksi\StockaController@getStocka')->middleware(['auth'])->name('get-stocka');
	
    Route::get('/get-stocka-post', 'App\Http\Controllers\OTransaksi\StockaController@getStocka_posting')->middleware(['auth'])->name('get-stocka-post');
	
    Route::get('/get-stocka-report', 'App\Http\Controllers\OReport\RStockaController@getStockaReport')->middleware(['auth'])->name('get-stocka-report');
    Route::get('/jspoc/{stocka:NO_ID}', 'App\Http\Controllers\OTransaksi\StockaController@jsstockac')->middleware(['auth']);
    Route::post('jasper-stocka-report', 'App\Http\Controllers\OReport\RStockaController@jasperStockaReport')->middleware(['auth']);

    Route::get('/stocka/browse_pod', 'App\Http\Controllers\OTransaksi\StockaController@browse_stockad')->middleware(['auth'])->name('stocka/browse_stockad');
	
// Dynamic Stocka
Route::get('/stocka/edit', 'App\Http\Controllers\OTransaksi\StockaController@edit')->middleware(['auth'])->name('stocka.edit');
Route::post('/stocka/update/{stocka}', 'App\Http\Controllers\OTransaksi\StockaController@update')->middleware(['auth'])->name('stocka.update');
Route::get('/stocka/delete/{stocka}', 'App\Http\Controllers\OTransaksi\StockaController@destroy')->middleware(['auth'])->name('stocka.delete');
Route::get('/stocka/repost/{stocka}', 'App\Http\Controllers\OTransaksi\StockaController@repost')->middleware(['auth'])->name('stocka.repost');

Route::post('stocka/posting', 'App\Http\Controllers\OTransaksi\StockaController@posting')->middleware(['auth']);
Route::get('stocka/index-posting', 'App\Http\Controllers\OTransaksi\StockaController@index_posting')->middleware(['auth']);

// Posting
Route::get('/posting/index', 'App\Http\Controllers\PostingController@index')->middleware(['auth']);
Route::post('/posting/proses', 'App\Http\Controllers\PostingController@posting')->middleware(['auth']);



// Operational Stockb

Route::get('/stockb', 'App\Http\Controllers\OTransaksi\StockbController@index')->middleware(['auth'])->name('stockb');
Route::post('/stockb/store', 'App\Http\Controllers\OTransaksi\StockbController@store')->middleware(['auth'])->name('stockb/store');
Route::get('/rstockb', 'App\Http\Controllers\OReport\RStockbController@report')->middleware(['auth'])->name('rstockb');
    
// GET Stockb
    Route::get('/stockb/browse', 'App\Http\Controllers\OTransaksi\StockbController@browse')->middleware(['auth'])->name('stockb/browse');
    Route::get('/stockb/browse_detail', 'App\Http\Controllers\OTransaksi\StockbController@browse_detail')->middleware(['auth'])->name('stockb/browse_detail');
    Route::get('/stockb/browseuang', 'App\Http\Controllers\OTransaksi\StockbController@browseuang')->middleware(['auth'])->name('stockb/browseuang');
   
    Route::get('/get-stockb', 'App\Http\Controllers\OTransaksi\StockbController@getStockb')->middleware(['auth'])->name('get-stockb');
	
    Route::get('/get-stockb-post', 'App\Http\Controllers\OTransaksi\StockbController@getStockb_posting')->middleware(['auth'])->name('get-stockb-post');
	
    Route::get('/get-stockb-report', 'App\Http\Controllers\OReport\RStockbController@getStockbReport')->middleware(['auth'])->name('get-stockb-report');
    Route::get('/jspoc/{stockb:NO_ID}', 'App\Http\Controllers\OTransaksi\StockbController@jspoc')->middleware(['auth']);
    Route::post('jasper-stockb-report', 'App\Http\Controllers\OReport\RStockbController@jasperStockbReport')->middleware(['auth']);

    Route::get('/stockb/browse_pod', 'App\Http\Controllers\OTransaksi\StockbController@browse_stockbd')->middleware(['auth'])->name('stockb/browse_stockbd');
	
// Dynamic Stockb
Route::get('/stockb/edit', 'App\Http\Controllers\OTransaksi\StockbController@edit')->middleware(['auth'])->name('stockb.edit');
Route::post('/stockb/update/{stockb}', 'App\Http\Controllers\OTransaksi\StockbController@update')->middleware(['auth'])->name('stockb.update');
Route::get('/stockb/delete/{stockb}', 'App\Http\Controllers\OTransaksi\StockbController@destroy')->middleware(['auth'])->name('stockb.delete');
Route::get('/stockb/repost/{stockb}', 'App\Http\Controllers\OTransaksi\StockbController@repost')->middleware(['auth'])->name('stockb.repost');

Route::post('stockb/posting', 'App\Http\Controllers\OTransaksi\StockbController@posting')->middleware(['auth']);
Route::get('stockb/index-posting', 'App\Http\Controllers\OTransaksi\StockbController@index_posting')->middleware(['auth']);

// Posting
Route::get('/posting/index', 'App\Http\Controllers\PostingController@index')->middleware(['auth']);
Route::post('/posting/proses', 'App\Http\Controllers\PostingController@posting')->middleware(['auth']);



// Operational Surat
Route::get('/surats', 'App\Http\Controllers\OTransaksi\SuratsController@index')->middleware(['auth'])->name('surats');
Route::post('/surats/store', 'App\Http\Controllers\OTransaksi\SuratsController@store')->middleware(['auth'])->name('surats/store');
Route::get('/surats/create', 'App\Http\Controllers\OTransaksi\SuratsController@create')->middleware(['auth'])->name('surats/create');
Route::get('/get-surats', 'App\Http\Controllers\OTransaksi\SuratsController@getSurats')->middleware(['auth'])->name('get-surats');
Route::get('/rsurats', 'App\Http\Controllers\OReport\RSuratsController@report')->middleware(['auth'])->name('rsurats');
Route::get('/surats/browse', 'App\Http\Controllers\OTransaksi\SuratsController@browse')->middleware(['auth'])->name('surats/browse');

Route::get('/surats/show/{surats}', 'App\Http\Controllers\OTransaksi\SuratsController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('suratsid');
Route::get('/surats/edit', 'App\Http\Controllers\OTransaksi\SuratsController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('surats.edit');
Route::post('/surats/update/{surats}', 'App\Http\Controllers\OTransaksi\SuratsController@update')->middleware(['auth', 'role:superadmin|operational'])->name('surats.update');
Route::get('/surats/delete/{surats}', 'App\Http\Controllers\OTransaksi\SuratsController@destroy')->middleware(['auth', 'role:superadmin'])->name('surats.delete');

Route::get('/surats/browseCust', 'App\Http\Controllers\OTransaksi\SuratsController@browseCust')->middleware(['auth']);
Route::get('/surats/browseSo', 'App\Http\Controllers\OTransaksi\SuratsController@browseSo')->middleware(['auth']);
Route::get('/surats/browse_detail', 'App\Http\Controllers\OTransaksi\SuratsController@browse_detail')->middleware(['auth']);

Route::post('/jasper-surats-report', 'App\Http\Controllers\OReport\RSuratsController@jasperSuratsReport')->middleware(['auth']);
Route::get('/jssuratsc/{surats:NO_ID}', 'App\Http\Controllers\OTransaksi\SuratsController@jssuratsc')->middleware(['auth']);


// Operational Penjualan
Route::get('/jual', 'App\Http\Controllers\OTransaksi\JualController@index')->middleware(['auth'])->name('jual');
Route::post('/jual/store', 'App\Http\Controllers\OTransaksi\JualController@store')->middleware(['auth'])->name('jual/store');
Route::get('/jual/create', 'App\Http\Controllers\OTransaksi\JualController@create')->middleware(['auth'])->name('jual/create');
Route::get('/get-jual', 'App\Http\Controllers\OTransaksi\JualController@getJual')->middleware(['auth'])->name('get-jual');
Route::get('/rjual', 'App\Http\Controllers\OReport\RJualController@report')->middleware(['auth'])->name('rjual');
Route::get('/get-jual-report', 'App\Http\Controllers\OReport\RJualController@getJualReport')->middleware(['auth'])->name('get-jual-report');

Route::get('/jual/show/{jual}', 'App\Http\Controllers\OTransaksi\JualController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('jualid');
Route::get('/jual/edit/{jual}', 'App\Http\Controllers\OTransaksi\JualController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('jual.edit');
Route::post('/jual/update/{jual}', 'App\Http\Controllers\OTransaksi\JualController@update')->middleware(['auth', 'role:superadmin|operational'])->name('jual.update');
Route::get('/jual/delete/{jual}', 'App\Http\Controllers\OTransaksi\JualController@destroy')->middleware(['auth', 'role:superadmin'])->name('jual.delete');

Route::get('/jual/browseSj', 'App\Http\Controllers\OTransaksi\JualController@browseSj')->middleware(['auth']);
Route::get('/jual/browseSuratsd', 'App\Http\Controllers\OTransaksi\JualController@browseSuratsd')->middleware(['auth']);
Route::get('/jual/browseSo', 'App\Http\Controllers\OTransaksi\JualController@browseSo')->middleware(['auth']);
Route::get('/jual/browse', 'App\Http\Controllers\OTransaksi\JualController@browse')->middleware(['auth'])->name('jual/browse');

Route::post('/jasper-jual-report', 'App\Http\Controllers\OReport\RJualController@jasperJualReport')->middleware(['auth']);
Route::get('/jsjualc/{jual:NO_ID}', 'App\Http\Controllers\OTransaksi\JualController@jsjualc')->middleware(['auth']);



// Operational Beli
Route::get('/beli', 'App\Http\Controllers\OTransaksi\BeliController@index')->middleware(['auth'])->name('beli');
Route::post('/beli/store', 'App\Http\Controllers\OTransaksi\BeliController@store')->middleware(['auth'])->name('beli/store');
Route::get('/rbeli', 'App\Http\Controllers\OReport\RBeliController@report')->middleware(['auth'])->name('rbeli');
    // GET BELI
    Route::get('/beli/browse', 'App\Http\Controllers\OTransaksi\BeliController@browse')->middleware(['auth'])->name('beli/browse');
    Route::get('/beli/browse_detail', 'App\Http\Controllers\OTransaksi\BeliController@browse_detail')->middleware(['auth'])->name('beli/browse_detail');
    Route::get('/beli/browse_detail2', 'App\Http\Controllers\OTransaksi\BeliController@browse_detail2')->middleware(['auth'])->name('beli/browse_detail2');
   
    Route::get('/beli/browseuang', 'App\Http\Controllers\OTransaksi\BeliController@browseuang')->middleware(['auth'])->name('beli/browseuang');
    Route::get('/get-beli', 'App\Http\Controllers\OTransaksi\BeliController@getBeli')->middleware(['auth'])->name('get-beli');
	
    Route::get('/get-beli-post', 'App\Http\Controllers\OTransaksi\BeliController@getBeli_posting')->middleware(['auth'])->name('get-beli-post');
	
    Route::get('/get-beli-report', 'App\Http\Controllers\OReport\RBeliController@getBeliReport')->middleware(['auth'])->name('get-beli-report');
	Route::get('/beli/cetak/{beli:NO_ID}','App\Http\Controllers\OTransaksi\BeliController@cetak')->middleware(['auth']);
    // Route::get('/jsbelic/{beli:NO_ID}', 'App\Http\Controllers\OTransaksi\BeliController@jsbelic')->middleware(['auth']);
    Route::post('jasper-beli-report', 'App\Http\Controllers\OReport\RBeliController@jasperBeliReport')->middleware(['auth']);

    Route::get('/beli/browse_belid', 'App\Http\Controllers\OTransaksi\BeliController@browse_belid')->middleware(['auth'])->name('beli/browse_belid');
	
// Dynamic Beli
Route::get('/beli/edit', 'App\Http\Controllers\OTransaksi\BeliController@edit')->middleware(['auth'])->name('beli.edit');
Route::post('/beli/update/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@update')->middleware(['auth'])->name('beli.update');
Route::get('/beli/delete/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@destroy')->middleware(['auth'])->name('beli.delete');
Route::get('/beli/repost/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@repost')->middleware(['auth'])->name('beli.repost');

Route::post('beli/posting', 'App\Http\Controllers\OTransaksi\BeliController@posting')->middleware(['auth']);
Route::get('beli/index-posting', 'App\Http\Controllers\OTransaksi\BeliController@index_posting')->middleware(['auth']);

////////////////////////////////////////////////////////

/////////////////////////////////////////////////////



// Operational Utbeli
Route::get('/utbeli', 'App\Http\Controllers\OTransaksi\UtbeliController@index')->middleware(['auth'])->name('utbeli');
Route::post('/utbeli/store', 'App\Http\Controllers\OTransaksi\UtbeliController@store')->middleware(['auth'])->name('utbeli/store');
Route::get('/rutbeli', 'App\Http\Controllers\OReport\RUtbeliController@report')->middleware(['auth'])->name('rutbeli');
    // GET Utbeli
    Route::get('/utbeli/browse', 'App\Http\Controllers\OTransaksi\UtbeliController@browse')->middleware(['auth'])->name('utbeli/browse');
    Route::get('/utbeli/browseuang', 'App\Http\Controllers\OTransaksi\UtbeliController@browseuang')->middleware(['auth'])->name('utbeli/browseuang');
    Route::get('/get-utbeli', 'App\Http\Controllers\OTransaksi\UtbeliController@getUtbeli')->middleware(['auth'])->name('get-utbeli');
    Route::get('/get-utbeli-report', 'App\Http\Controllers\OReport\RUtbeliController@getUtbeliReport')->middleware(['auth'])->name('get-utbeli-report');
    Route::post('jasper-utbeli-report', 'App\Http\Controllers\OReport\RUtbeliController@jasperUtbeliReport')->middleware(['auth']);
// Dynamic Utbeli
Route::get('/utbeli/edit', 'App\Http\Controllers\OTransaksi\UtbeliController@edit')->middleware(['auth'])->name('utbeli.edit');
Route::post('/utbeli/update/{utbeli}', 'App\Http\Controllers\OTransaksi\UtbeliController@update')->middleware(['auth'])->name('utbeli.update');
Route::get('/utbeli/delete/{utbeli}', 'App\Http\Controllers\OTransaksi\UtbeliController@destroy')->middleware(['auth'])->name('utbeli.delete');
Route::get('/utbeli/repost/{utbeli}', 'App\Http\Controllers\OTransaksi\UtbeliController@repost')->middleware(['auth'])->name('utbeli.repost');
Route::get('/jsutbelic/{utbeli:NO_ID}', 'App\Http\Controllers\OTransaksi\UtbeliController@jsutbelic')->middleware(['auth']);
    



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


//////////////////////////////////////////////////////////


// Operational Utjual
Route::get('/utjual', 'App\Http\Controllers\OTransaksi\UtjualController@index')->middleware(['auth'])->name('utjual');
Route::post('/utjual/store', 'App\Http\Controllers\OTransaksi\UtjualController@store')->middleware(['auth'])->name('utjual/store');
Route::get('/rutjual', 'App\Http\Controllers\OReport\RUtjualController@report')->middleware(['auth'])->name('rutjual');
    // GET Utjual
    Route::get('/utjual/browse', 'App\Http\Controllers\OTransaksi\UtjualController@browse')->middleware(['auth'])->name('utjual/browse');
    Route::get('/utjual/browseuang', 'App\Http\Controllers\OTransaksi\UtjualController@browseuang')->middleware(['auth'])->name('utjual/browseuang');
    Route::get('/get-utjual', 'App\Http\Controllers\OTransaksi\UtjualController@getUtjual')->middleware(['auth'])->name('get-utjual');
    Route::get('/get-utjual-report', 'App\Http\Controllers\OReport\RUtjualController@getUtjualReport')->middleware(['auth'])->name('get-utjual-report');
    Route::post('jasper-utjual-report', 'App\Http\Controllers\OReport\RUtjualController@jasperUtjualReport')->middleware(['auth']);
// Dynamic Utjual
Route::get('/utjual/edit', 'App\Http\Controllers\OTransaksi\UtjualController@edit')->middleware(['auth'])->name('utjual.edit');
Route::post('/utjual/update/{utjual}', 'App\Http\Controllers\OTransaksi\UtjualController@update')->middleware(['auth'])->name('utjual.update');
Route::get('/utjual/delete/{utjual}', 'App\Http\Controllers\OTransaksi\UtjualController@destroy')->middleware(['auth'])->name('utjual.delete');
Route::get('/utjual/repost/{utjual}', 'App\Http\Controllers\OTransaksi\UtjualController@repost')->middleware(['auth'])->name('utjual.repost');
Route::get('/jsutjualc/{utjual:NO_ID}', 'App\Http\Controllers\OTransaksi\UtjualController@jsutjualc')->middleware(['auth']);
    


/// HUT

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




// PIU

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
Route::get('/piu/browse_piud', 'App\Http\Controllers\OTransaksi\PiuController@browse_piud')->middleware(['auth'])->name('piu/browse_piud');


// Operational Transaksi Kik
Route::get('/kik', 'App\Http\Controllers\OTransaksi\KikController@index')->middleware(['auth'])->name('kik');
Route::post('/kik/store', 'App\Http\Controllers\OTransaksi\KikController@store')->middleware(['auth'])->name('kik/store');
Route::get('/kik/create', 'App\Http\Controllers\OTransaksi\KikController@create')->middleware(['auth'])->name('terima/create');
Route::get('/get-kik', 'App\Http\Controllers\OTransaksi\KikController@getKik')->middleware(['auth'])->name('get-kik');
Route::get('/rkik', 'App\Http\Controllers\OReport\RKikController@report')->middleware(['auth'])->name('rkik');
Route::get('/get-kik-report', 'App\Http\Controllers\OReport\RKikController@getKikReport')->middleware(['auth'])->name('get-kik-report');

Route::get('kik/index-posting', 'App\Http\Controllers\OTransaksi\KikController@index_posting')->middleware(['auth']);



// Operational Memo
Route::get('/memo', 'App\Http\Controllers\FTransaksi\MemoController@index')->middleware(['auth'])->name('memo');
Route::post('/memo/store', 'App\Http\Controllers\FTransaksi\MemoController@store')->middleware(['auth'])->name('memo/store');
Route::get('/memo/create', 'App\Http\Controllers\FTransaksi\MemoController@create')->middleware(['auth'])->name('memo/create');
Route::get('/get-memo', 'App\Http\Controllers\FTransaksi\MemoController@getMemo')->middleware(['auth'])->name('get-memo');
Route::get('/rmemo', 'App\Http\Controllers\FReport\RMemoController@report')->middleware(['auth'])->name('rmemo');
Route::get('/get-memo-report', 'App\Http\Controllers\FReport\RMemoController@getMemoReport')->middleware(['auth'])->name('get-memo-report');

// Operational Kas Masuk
Route::get('/kas', 'App\Http\Controllers\FTransaksi\KasController@index')->middleware(['auth'])->name('kas');
Route::post('/kas/store', 'App\Http\Controllers\FTransaksi\KasController@store')->middleware(['auth'])->name('kas/store');
Route::get('/kas/create', 'App\Http\Controllers\FTransaksi\KasController@create')->middleware(['auth'])->name('kas/create');
Route::get('/get-kas', 'App\Http\Controllers\FTransaksi\KasController@getKas')->middleware(['auth'])->name('get-kas');
Route::get('/rkas', 'App\Http\Controllers\FReport\RKasController@report')->middleware(['auth'])->name('rkas');
Route::get('/get-kas-report', 'App\Http\Controllers\FReport\RKasController@getKasReport')->middleware(['auth'])->name('get-kas-report');




// Operational Kas Keluar
Route::get('/kask', 'App\Http\Controllers\FTransaksi\KaskController@index')->middleware(['auth'])->name('kask');
Route::post('/kask/store', 'App\Http\Controllers\FTransaksi\KaskController@store')->middleware(['auth'])->name('kask/store');
Route::get('/kask/create', 'App\Http\Controllers\FTransaksi\KaskController@create')->middleware(['auth'])->name('kask/create');
Route::get('/get-kask', 'App\Http\Controllers\FTransaksi\KaskController@getKask')->middleware(['auth'])->name('get-kask');

// Operational Bank Masuk
Route::get('/bank', 'App\Http\Controllers\FTransaksi\BankController@index')->middleware(['auth'])->name('bank');
Route::post('/bank/store', 'App\Http\Controllers\FTransaksi\BankController@store')->middleware(['auth'])->name('bank/store');
Route::get('/bank/create', 'App\Http\Controllers\FTransaksi\BankController@create')->middleware(['auth'])->name('bank/create');
Route::get('/get-bank', 'App\Http\Controllers\FTransaksi\BankController@getBank')->middleware(['auth'])->name('get-bank');
Route::get('/rbank', 'App\Http\Controllers\FReport\RBankController@report')->middleware(['auth'])->name('rbank');
Route::get('/get-bank-report', 'App\Http\Controllers\FReport\RBankController@getBankReport')->middleware(['auth'])->name('get-bank-report');


// Operational Bank Keluar
Route::get('/bankk', 'App\Http\Controllers\FTransaksi\BankkController@index')->middleware(['auth'])->name('bankk');
Route::post('/bankk/store', 'App\Http\Controllers\FTransaksi\BankkController@store')->middleware(['auth'])->name('bankk/store');
Route::get('/bankk/create', 'App\Http\Controllers\FTransaksi\BankkController@create')->middleware(['auth'])->name('bankk/create');
Route::get('/get-bankk', 'App\Http\Controllers\FTransaksi\BankkController@getBankk')->middleware(['auth'])->name('get-bankk');











/// PEMBATAS DENGAN BAWAH














//Dynamic Route

// User
Route::get('/user/show/{user}', 'App\Http\Controllers\UserController@show')->middleware(['auth', 'role:superadmin'])->name('userid');
Route::get('/user/edit/{user}', 'App\Http\Controllers\UserController@edit')->middleware(['auth', 'role:superadmin'])->name('useredit');
Route::get('/user/delete/{user}', 'App\Http\Controllers\UserController@destroy')->middleware(['auth', 'role:superadmin'])->name('userid');
Route::post('/user/update/{user}', 'App\Http\Controllers\UserController@update')->middleware(['auth', 'role:superadmin'])->name('userid');



// // Bahan
// Route::get('/bhn/show/{bhn}', 'App\Http\Controllers\Master\BhnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('bhnid');
// Route::get('/bhn/edit/{bhn}', 'App\Http\Controllers\Master\BhnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('bhn.edit');
// Route::post('/bhn/update/{bhn}', 'App\Http\Controllers\Master\BhnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('bhn.update');
// Route::get('/bhn/delete/{bhn}', 'App\Http\Controllers\Master\BhnController@destroy')->middleware(['auth', 'role:superadmin'])->name('bhn.delete');


// // Barang
// Route::get('/brg/show/{brg}', 'App\Http\Controllers\Master\BrgController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('brgid');
// Route::get('/brg/edit/{brg}', 'App\Http\Controllers\Master\BrgController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('brg.edit');
// Route::post('/brg/update/{brg}', 'App\Http\Controllers\Master\BrgController@update')->middleware(['auth', 'role:superadmin|operational'])->name('brg.update');
// Route::get('/brg/delete/{brg}', 'App\Http\Controllers\Master\BrgController@destroy')->middleware(['auth', 'role:superadmin'])->name('brg.delete');


// // Formula
// Route::get('/fo/show/{fo}', 'App\Http\Controllers\Master\FoController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('foid');
// Route::get('/fo/edit/{fo}', 'App\Http\Controllers\Master\FoController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('fo.edit');
// Route::post('/fo/update/{fo}', 'App\Http\Controllers\Master\FoController@update')->middleware(['auth', 'role:superadmin|operational'])->name('fo.update');
// Route::get('/fo/delete/{fo}', 'App\Http\Controllers\Master\FoController@destroy')->middleware(['auth', 'role:superadmin'])->name('fo.delete');


// // Proses
// Route::get('/prs/show/{prs}', 'App\Http\Controllers\Master\PrsController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('prsid');
// Route::get('/prs/edit/{prs}', 'App\Http\Controllers\Master\PrsController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('prs.edit');
// Route::post('/prs/update/{prs}', 'App\Http\Controllers\Master\PrsController@update')->middleware(['auth', 'role:superadmin|operational'])->name('prs.update');
// Route::get('/prs/delete/{prs}', 'App\Http\Controllers\Master\PrsController@destroy')->middleware(['auth', 'role:superadmin'])->name('prs.delete');

// Po Non
Route::get('/pon/show/{pon}', 'App\Http\Controllers\OTransaksi\PonController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('ponid');
Route::get('/pon/edit/{pon}', 'App\Http\Controllers\OTransaksi\PonController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pon.edit');
Route::post('/pon/update/{pon}', 'App\Http\Controllers\OTransaksi\PonController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pon.update');
Route::get('/pon/delete/{pon}', 'App\Http\Controllers\OTransaksi\PonController@destroy')->middleware(['auth', 'role:superadmin'])->name('pon.delete');


// Po Sparepart
Route::get('/pos/show/{pos}', 'App\Http\Controllers\OTransaksi\PosController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('posid');
Route::get('/pos/edit/{pos}', 'App\Http\Controllers\OTransaksi\PosController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pos.edit');
Route::post('/pos/update/{pos}', 'App\Http\Controllers\OTransaksi\PosController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pos.update');
Route::get('/pos/delete/{pos}', 'App\Http\Controllers\OTransaksi\PosController@destroy')->middleware(['auth', 'role:superadmin'])->name('pos.delete');

// Po Bahan Baku
Route::get('/pob/show/{pob}', 'App\Http\Controllers\OTransaksi\PobController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('pobid');
Route::get('/pob/edit/{pob}', 'App\Http\Controllers\OTransaksi\PobController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pob.edit');
Route::post('/pob/update/{pob}', 'App\Http\Controllers\OTransaksi\PobController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pob.update');
Route::get('/pob/delete/{pob}', 'App\Http\Controllers\OTransaksi\PobController@destroy')->middleware(['auth', 'role:superadmin'])->name('pob.delete');



// So
Route::get('/so/show/{so}', 'App\Http\Controllers\OTransaksi\SoController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('soid');
Route::get('/so/edit/{so}', 'App\Http\Controllers\OTransaksi\SoController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('so.edit');
Route::post('/so/update/{so}', 'App\Http\Controllers\OTransaksi\SoController@update')->middleware(['auth', 'role:superadmin|operational'])->name('so.update');
Route::get('/so/delete/{so}', 'App\Http\Controllers\OTransaksi\SoController@destroy')->middleware(['auth', 'role:superadmin'])->name('so.delete');


// So Bahan Baku
Route::get('/sob/show/{sob}', 'App\Http\Controllers\OTransaksi\SobController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('sobid');
Route::get('/sob/edit/{sob}', 'App\Http\Controllers\OTransaksi\SobController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('sob.edit');
Route::post('/sob/update/{sob}', 'App\Http\Controllers\OTransaksi\SobController@update')->middleware(['auth', 'role:superadmin|operational'])->name('sob.update');
Route::get('/sob/delete/{sob}', 'App\Http\Controllers\OTransaksi\SobController@destroy')->middleware(['auth', 'role:superadmin'])->name('sob.delete');


// So Non
Route::get('/son/show/{son}', 'App\Http\Controllers\OTransaksi\SonController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('sonid');
Route::get('/son/edit/{son}', 'App\Http\Controllers\OTransaksi\SonController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('son.edit');
Route::post('/son/update/{son}', 'App\Http\Controllers\OTransaksi\SonController@update')->middleware(['auth', 'role:superadmin|operational'])->name('son.update');
Route::get('/son/delete/{son}', 'App\Http\Controllers\OTransaksi\SonController@destroy')->middleware(['auth', 'role:superadmin'])->name('son.delete');

// So Bahan Baku
Route::get('/sob/show/{sob}', 'App\Http\Controllers\OTransaksi\SobController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('sobid');
Route::get('/sob/edit/{son}', 'App\Http\Controllers\OTransaksi\SobController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('sob.edit');
Route::post('/sob/update/{son}', 'App\Http\Controllers\OTransaksi\SobController@update')->middleware(['auth', 'role:superadmin|operational'])->name('sob.update');
Route::get('/sob/delete/{son}', 'App\Http\Controllers\OTransaksi\SobController@destroy')->middleware(['auth', 'role:superadmin'])->name('sob.delete');


// Orderk
Route::get('/orderk/show/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('orderkid');
Route::get('/orderk/edit/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('orderk.edit');
Route::post('/orderk/update/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@update')->middleware(['auth', 'role:superadmin|operational'])->name('orderk.update');
Route::get('/orderk/delete/{orderk}', 'App\Http\Controllers\OTransaksi\OrderkController@destroy')->middleware(['auth', 'role:superadmin'])->name('orderk.delete');


// Kik
Route::get('/kik/show/{kik}', 'App\Http\Controllers\OTransaksi\KikController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('kikid');
Route::get('/kik/edit/{kik}', 'App\Http\Controllers\OTransaksi\KikController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('kik.edit');
Route::post('/kik/update/{kik}', 'App\Http\Controllers\OTransaksi\KikController@update')->middleware(['auth', 'role:superadmin|operational'])->name('kik.update');
Route::get('/kik/delete/{kik}', 'App\Http\Controllers\OTransaksi\KikController@destroy')->middleware(['auth', 'role:superadmin'])->name('kik.delete');

// Pakai
Route::get('/pakai/show/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('pakaiid');
Route::get('/pakai/edit/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pakai.edit');
Route::post('/pakai/update/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pakai.update');
Route::get('/pakai/delete/{pakai}', 'App\Http\Controllers\OTransaksi\PakaiController@destroy')->middleware(['auth', 'role:superadmin'])->name('pakai.delete');

// Pakai Sparepart
Route::get('/pakais/show/{pakais}', 'App\Http\Controllers\OTransaksi\PakaisController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('pakaisid');
Route::get('/pakais/edit/{pakais}', 'App\Http\Controllers\OTransaksi\PakaisController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('pakais.edit');
Route::post('/pakais/update/{pakais}', 'App\Http\Controllers\OTransaksi\PakaisController@update')->middleware(['auth', 'role:superadmin|operational'])->name('pakais.update');
Route::get('/pakais/delete/{pakais}', 'App\Http\Controllers\OTransaksi\PakaisController@destroy')->middleware(['auth', 'role:superadmin'])->name('pakais.delete');

// Terima
Route::get('/terima/show/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('terimaid');
Route::get('/terima/edit/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('terima.edit');
Route::post('/terima/update/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@update')->middleware(['auth', 'role:superadmin|operational'])->name('terima.update');
Route::get('/terima/delete/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@destroy')->middleware(['auth', 'role:superadmin'])->name('terima.delete');

// Stocka Sparepart
Route::get('/stockas/show/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('stockasid');
Route::get('/stockas/edit/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('stockas.edit');
Route::post('/stockas/update/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@update')->middleware(['auth', 'role:superadmin|operational'])->name('stockas.update');
Route::get('/stockas/delete/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@destroy')->middleware(['auth', 'role:superadmin'])->name('stockas.delete');


// Beli
Route::get('/beli/show/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('beliid');
Route::get('/beli/edit/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('beli.edit');
Route::post('/beli/update/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@update')->middleware(['auth', 'role:superadmin|operational'])->name('beli.update');
Route::get('/beli/delete/{beli}', 'App\Http\Controllers\OTransaksi\BeliController@destroy')->middleware(['auth', 'role:superadmin'])->name('beli.delete');

// Beli Non
Route::get('/belin/show/{belin}', 'App\Http\Controllers\OTransaksi\BelinController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('belinid');
Route::get('/belin/edit/{belin}', 'App\Http\Controllers\OTransaksi\BelinController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('belin.edit');
Route::post('/belin/update/{belin}', 'App\Http\Controllers\OTransaksi\BelinController@update')->middleware(['auth', 'role:superadmin|operational'])->name('belin.update');
Route::get('/belin/delete/{belin}', 'App\Http\Controllers\OTransaksi\BelinController@destroy')->middleware(['auth', 'role:superadmin'])->name('belin.delete');


// Beli Bahan Baku
Route::get('/belib/show/{belib}', 'App\Http\Controllers\OTransaksi\BelibController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('belibid');
Route::get('/belib/edit/{belib}', 'App\Http\Controllers\OTransaksi\BelibController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('belib.edit');
Route::post('/belib/update/{belib}', 'App\Http\Controllers\OTransaksi\BelibController@update')->middleware(['auth', 'role:superadmin|operational'])->name('belib.update');
Route::get('/belib/delete/{belib}', 'App\Http\Controllers\OTransaksi\BelibController@destroy')->middleware(['auth', 'role:superadmin'])->name('belib.delete');

// Beli Sparepart
Route::get('/belis/show/{belis}', 'App\Http\Controllers\OTransaksi\BelisController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('belisid');
Route::get('/belis/edit/{belis}', 'App\Http\Controllers\OTransaksi\BelisController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('belis.edit');
Route::post('/belis/update/{belis}', 'App\Http\Controllers\OTransaksi\BelisController@update')->middleware(['auth', 'role:superadmin|operational'])->name('belis.update');
Route::get('/belis/delete/{belis}', 'App\Http\Controllers\OTransaksi\BelisController@destroy')->middleware(['auth', 'role:superadmin'])->name('belis.delete');



// Thut
Route::get('/thut/show/{thut}', 'App\Http\Controllers\OTransaksi\ThutController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('thutid');
Route::get('/thut/edit/{thut}', 'App\Http\Controllers\OTransaksi\ThutController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('thut.edit');
Route::post('/thut/update/{thut}', 'App\Http\Controllers\OTransaksi\ThutController@update')->middleware(['auth', 'role:superadmin|operational'])->name('thut.update');
Route::get('/thut/delete/{thut}', 'App\Http\Controllers\OTransaksi\ThutController@destroy')->middleware(['auth', 'role:superadmin'])->name('thut.delete');

// Thut Non
Route::get('/thutn/show/{thutn}', 'App\Http\Controllers\OTransaksi\ThutnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('thutnid');
Route::get('/thutn/edit/{thutn}', 'App\Http\Controllers\OTransaksi\ThutnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('thutn.edit');
Route::post('/thutn/update/{thutn}', 'App\Http\Controllers\OTransaksi\ThutnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('thutn.update');
Route::get('/thutn/delete/{thutn}', 'App\Http\Controllers\OTransaksi\ThutnController@destroy')->middleware(['auth', 'role:superadmin'])->name('thutn.delete');

// Thut Bahan Baku
Route::get('/thutb/b/{thutb}', 'App\Http\Controllers\OTransaksi\ThutbController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('thutbid');
Route::get('/thutb/edit/{thutb}', 'App\Http\Controllers\OTransaksi\ThutbController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('thutb.edit');
Route::post('/thutb/update/{thutb}', 'App\Http\Controllers\OTransaksi\ThutbController@update')->middleware(['auth', 'role:superadmin|operational'])->name('thutb.update');
Route::get('/thutb/delete/{thutb}', 'App\Http\Controllers\OTransaksi\ThutbController@destroy')->middleware(['auth', 'role:superadmin'])->name('thutb.delete');


// Um Beli 
Route::get('/um/show/{um}', 'App\Http\Controllers\OTransaksi\UmController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('umid');
Route::get('/um/edit/{um}', 'App\Http\Controllers\OTransaksi\UmController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('um.edit');
Route::post('/um/update/{um}', 'App\Http\Controllers\OTransaksi\UmController@update')->middleware(['auth', 'role:superadmin|operational'])->name('um.update');
Route::get('/um/delete/{um}', 'App\Http\Controllers\OTransaksi\UmController@destroy')->middleware(['auth', 'role:superadmin'])->name('um.delete');

// Um Beli Bahan Baku
Route::get('/umb/show/{umb}', 'App\Http\Controllers\OTransaksi\UmbController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('umbid');
Route::get('/umb/edit/{umb}', 'App\Http\Controllers\OTransaksi\UmbController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('umb.edit');
Route::post('/umb/update/{umb}', 'App\Http\Controllers\OTransaksi\UmbController@update')->middleware(['auth', 'role:superadmin|operational'])->name('umb.update');
Route::get('/umb/delete/{umb}', 'App\Http\Controllers\OTransaksi\UmbController@destroy')->middleware(['auth', 'role:superadmin'])->name('umb.delete');

// Um Beli Non
Route::get('/umn/show/{umn}', 'App\Http\Controllers\OTransaksi\UmnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('umnid');
Route::get('/umn/edit/{umn}', 'App\Http\Controllers\OTransaksi\UmnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('umn.edit');
Route::post('/umn/update/{umn}', 'App\Http\Controllers\OTransaksi\UmnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('umn.update');
Route::get('/umn/delete/{umn}', 'App\Http\Controllers\OTransaksi\UmnController@destroy')->middleware(['auth', 'role:superadmin'])->name('umn.delete');


// Um Beli Saprepart
Route::get('/ums/show/{ums}', 'App\Http\Controllers\OTransaksi\UmsController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('umsid');
Route::get('/ums/edit/{ums}', 'App\Http\Controllers\OTransaksi\UmsController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('ums.edit');
Route::post('/ums/update/{ums}', 'App\Http\Controllers\OTransaksi\UmsController@update')->middleware(['auth', 'role:superadmin|operational'])->name('ums.update');
Route::get('/ums/delete/{ums}', 'App\Http\Controllers\OTransaksi\UmsController@destroy')->middleware(['auth', 'role:superadmin'])->name('ums.delete');



// Jual
Route::get('/jual/show/{jual}', 'App\Http\Controllers\OTransaksi\JualController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('jualid');
Route::get('/jual/edit/{jual}', 'App\Http\Controllers\OTransaksi\JualController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('jual.edit');
Route::post('/jual/update/{jual}', 'App\Http\Controllers\OTransaksi\JualController@update')->middleware(['auth', 'role:superadmin|operational'])->name('jual.update');
Route::get('/jual/delete/{jual}', 'App\Http\Controllers\OTransaksi\JualController@destroy')->middleware(['auth', 'role:superadmin'])->name('jual.delete');

// Jual
Route::get('/jualn/show/{jualn}', 'App\Http\Controllers\OTransaksi\JualnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('jualnid');
Route::get('/jualn/edit/{jualn}', 'App\Http\Controllers\OTransaksi\JualnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('jualn.edit');
Route::post('/jualn/update/{jualn}', 'App\Http\Controllers\OTransaksi\JualnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('jualn.update');
Route::get('/jualn/delete/{jualn}', 'App\Http\Controllers\OTransaksi\JualnController@destroy')->middleware(['auth', 'role:superadmin'])->name('jualn.delete');

// Jual
Route::get('/jual/show/{jual}', 'App\Http\Controllers\OTransaksi\JualController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('jualid');
Route::get('/jual/edit/{jual}', 'App\Http\Controllers\OTransaksi\JualController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('jual.edit');
Route::post('/jual/update/{jual}', 'App\Http\Controllers\OTransaksi\JualController@update')->middleware(['auth', 'role:superadmin|operational'])->name('jual.update');
Route::get('/jual/delete/{jual}', 'App\Http\Controllers\OTransaksi\JualController@destroy')->middleware(['auth', 'role:superadmin'])->name('jual.delete');





// Tpiu
Route::get('/tpiu/show/[tpiu}', 'App\Http\Controllers\OTransaksi\TpiuController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('tpiuid');
Route::get('/tpiu/edit/{tpiu}', 'App\Http\Controllers\OTransaksi\TpiuController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('tpiu.edit');
Route::post('/tpiu/update/{tpiu}', 'App\Http\Controllers\OTransaksi\TpiuController@update')->middleware(['auth', 'role:superadmin|operational'])->name('tpiu.update');
Route::get('/tpiu/delete/{tpiu}', 'App\Http\Controllers\OTransaksi\TpiuController@destroy')->middleware(['auth', 'role:superadmin'])->name('tpiu.delete');

// Tpiu Non
Route::get('/tpiun/show/[tpiun}', 'App\Http\Controllers\OTransaksi\TpiunController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('tpiunid');
Route::get('/tpiun/edit/{tpiun}', 'App\Http\Controllers\OTransaksi\TpiunController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('tpiun.edit');
Route::post('/tpiun/update/{tpiun}', 'App\Http\Controllers\OTransaksi\TpiunController@update')->middleware(['auth', 'role:superadmin|operational'])->name('tpiun.update');
Route::get('/tpiun/delete/{tpiun}', 'App\Http\Controllers\OTransaksi\TpiunController@destroy')->middleware(['auth', 'role:superadmin'])->name('tpiun.delete');


// Tpiu Bahan Baku
Route::get('/tpiub/show/[tpiu}', 'App\Http\Controllers\OTransaksi\TpiubController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('tpiubid');
Route::get('/tpiub/edit/{tpiub}', 'App\Http\Controllers\OTransaksi\TpiubController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('tpiub.edit');
Route::post('/tpiub/update/{tpiu}', 'App\Http\Controllers\OTransaksi\TpiubController@update')->middleware(['auth', 'role:superadmin|operational'])->name('tpiub.update');
Route::get('/tpiub/delete/{tpiu}', 'App\Http\Controllers\OTransaksi\TpiubController@destroy')->middleware(['auth', 'role:superadmin'])->name('tpiub.delete');



// Uj 
Route::get('/uj/show/[uj]', 'App\Http\Controllers\OTransaksi\UjController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('ujid');
Route::get('/uj/edit/{uj}', 'App\Http\Controllers\OTransaksi\UjController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('uj.edit');
Route::post('/uj/update/{uj}', 'App\Http\Controllers\OTransaksi\UjController@update')->middleware(['auth', 'role:superadmin|operational'])->name('uj.update');
Route::get('/uj/delete/{umj}', 'App\Http\Controllers\OTransaksi\UjController@destroy')->middleware(['auth', 'role:superadmin'])->name('uj.delete');

// Umj Non
Route::get('/ujn/show/[ujn]', 'App\Http\Controllers\OTransaksi\UjnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('ujnid');
Route::get('/ujn/edit/{ujn}', 'App\Http\Controllers\OTransaksi\UjnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('ujn.edit');
Route::post('/ujn/update/{ujn}', 'App\Http\Controllers\OTransaksi\UjnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('ujn.update');
Route::get('/ujn/delete/{ujn}', 'App\Http\Controllers\OTransaksi\UjnController@destroy')->middleware(['auth', 'role:superadmin'])->name('ujn.delete');

// Umj Bahan Baku
Route::get('/ujb/show/[ujb]', 'App\Http\Controllers\OTransaksi\UjbController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('ujbid');
Route::get('/ujb/edit/{ujb}', 'App\Http\Controllers\OTransaksi\UjbController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('ujb.edit');
Route::post('/ujb/update/{ujb}', 'App\Http\Controllers\OTransaksi\UjbController@update')->middleware(['auth', 'role:superadmin|operational'])->name('ujb.update');
Route::get('/ujb/delete/{ujb}', 'App\Http\Controllers\OTransaksi\UjbController@destroy')->middleware(['auth', 'role:superadmin'])->name('ujb.delete');


// Hut
Route::get('/hut/show/{hut}', 'App\Http\Controllers\OTransaksi\HutController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('hutid');
Route::get('/hut/edit/{hut}', 'App\Http\Controllers\OTransaksi\HutController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('hut.edit');
Route::post('/hut/update/{hut}', 'App\Http\Controllers\OTransaksi\HutController@update')->middleware(['auth', 'role:superadmin|operational'])->name('hut.update');
Route::get('/hut/delete/{hut}', 'App\Http\Controllers\OTransaksi\HutController@destroy')->middleware(['auth', 'role:superadmin'])->name('hut.delete');

// Hut Non
Route::get('/hutn/show/{hutn}', 'App\Http\Controllers\OTransaksi\HutnController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('hutnid');
Route::get('/hutn/edit/{hutn}', 'App\Http\Controllers\OTransaksi\HutnController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('hutn.edit');
Route::post('/hutn/update/{hutn}', 'App\Http\Controllers\OTransaksi\HutnController@update')->middleware(['auth', 'role:superadmin|operational'])->name('hutn.update');
Route::get('/hutn/delete/{hutn}', 'App\Http\Controllers\OTransaksi\HutnController@destroy')->middleware(['auth', 'role:superadmin'])->name('hutn.delete');


// Hut Sparepart
Route::get('/huts/show/{huts}', 'App\Http\Controllers\OTransaksi\HutsController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('hutsid');
Route::get('/huts/edit/{huts}', 'App\Http\Controllers\OTransaksi\HutsController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('huts.edit');
Route::post('/huts/update/{hutn}', 'App\Http\Controllers\OTransaksi\HutsController@update')->middleware(['auth', 'role:superadmin|operational'])->name('huts.update');
Route::get('/huts/delete/{huts}', 'App\Http\Controllers\OTransaksi\HutsController@destroy')->middleware(['auth', 'role:superadmin'])->name('huts.delete');



// Hut Bahan Baku
Route::get('/hutb/show/{hutb}', 'App\Http\Controllers\OTransaksi\HutbController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('hutbid');
Route::get('/hutb/edit/{hutb}', 'App\Http\Controllers\OTransaksi\HutbController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('hutb.edit');
Route::post('/hutn/update/{hutb}', 'App\Http\Controllers\OTransaksi\HutbController@update')->middleware(['auth', 'role:superadmin|operational'])->name('hutb.update');
Route::get('/hutb/delete/{hutb}', 'App\Http\Controllers\OTransaksi\HutbController@destroy')->middleware(['auth', 'role:superadmin'])->name('hutb.delete');



// Piu
Route::get('/piu/show/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('piuid');
Route::get('/piu/edit/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('piu.edit');
Route::post('/piu/update/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@update')->middleware(['auth', 'role:superadmin|operational'])->name('piu.update');
Route::get('/piu/delete/{piu}', 'App\Http\Controllers\OTransaksi\PiuController@destroy')->middleware(['auth', 'role:superadmin'])->name('piu.delete');



// Piu Non
Route::get('/piun/show/{piun}', 'App\Http\Controllers\OTransaksi\PiunController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('piunid');
Route::get('/piun/edit/{piun}', 'App\Http\Controllers\OTransaksi\PiunController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('piun.edit');
Route::post('/piun/update/{piun}', 'App\Http\Controllers\OTransaksi\PiunController@update')->middleware(['auth', 'role:superadmin|operational'])->name('piun.update');
Route::get('/piun/delete/{piun}', 'App\Http\Controllers\OTransaksi\PiunController@destroy')->middleware(['auth', 'role:superadmin'])->name('piun.delete');





// Piu Bahan Baku
Route::get('/piub/show/{piub}', 'App\Http\Controllers\OTransaksi\PiubController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('piubid');
Route::get('/piub/edit/{piub}', 'App\Http\Controllers\OTransaksi\PiubController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('piub.edit');
Route::post('/piub/update/{piub}', 'App\Http\Controllers\OTransaksi\PiubController@update')->middleware(['auth', 'role:superadmin|operational'])->name('piub.update');
Route::get('/piub/delete/{piub}', 'App\Http\Controllers\OTransaksi\PiubController@destroy')->middleware(['auth', 'role:superadmin'])->name('piub.delete');




// Terima
Route::get('/terima/show/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('terimaid');
Route::get('/terima/edit/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('terima.edit');
Route::post('/terima/update/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@update')->middleware(['auth', 'role:superadmin|operational'])->name('terima.update');
Route::get('/terima/delete/{terima}', 'App\Http\Controllers\OTransaksi\TerimaController@destroy')->middleware(['auth', 'role:superadmin'])->name('terima.delete');

// Stockas
Route::get('/stockas/show/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@show')->middleware(['auth', 'role:superadmin|view|operational'])->name('stockasid');
Route::get('/stockas/edit/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@edit')->middleware(['auth', 'role:superadmin|operational'])->name('stockas.edit');
Route::post('/stockas/update/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@update')->middleware(['auth', 'role:superadmin|operational'])->name('stockas.update');
Route::get('/stockas/delete/{stockas}', 'App\Http\Controllers\OTransaksi\StockasController@destroy')->middleware(['auth', 'role:superadmin'])->name('stockas.delete');


// Operational Memo
Route::get('/memo', 'App\Http\Controllers\FTransaksi\MemoController@index')->middleware(['auth'])->name('memo');
Route::post('/memo/store', 'App\Http\Controllers\FTransaksi\MemoController@store')->middleware(['auth'])->name('memo/store');
Route::get('/rmemo', 'App\Http\Controllers\FReport\RMemoController@report')->middleware(['auth'])->name('rmemo');
    // GET MEMO
    Route::get('/get-memo', 'App\Http\Controllers\FTransaksi\MemoController@getMemo')->middleware(['auth'])->name('get-memo');
    Route::get('/get-memo-report', 'App\Http\Controllers\FReport\RMemoController@getMemoReport')->middleware(['auth'])->name('get-memo-report');
    Route::post('memo/jasper-memo-report', 'App\Http\Controllers\FReport\RMemoController@jasperMemoReport')->middleware(['auth']);
// Dynamic Memo
Route::get('/memo/edit', 'App\Http\Controllers\FTransaksi\MemoController@edit')->middleware(['auth'])->name('memo.edit');
Route::post('/memo/update/{memo}', 'App\Http\Controllers\FTransaksi\MemoController@update')->middleware(['auth'])->name('memo.update');
Route::get('/memo/delete/{memo}', 'App\Http\Controllers\FTransaksi\MemoController@destroy')->middleware(['auth'])->name('memo.delete');
    
//Report
Route::post('/rmemo/cetak', 'App\Http\Controllers\FReport\RMemoController@cetak')->middleware(['auth'])->name('rmemo.cetak');

// Operational Kas Masuk
Route::get('/kas', 'App\Http\Controllers\FTransaksi\KasController@index')->middleware(['auth'])->name('kas');
Route::post('/kas/store', 'App\Http\Controllers\FTransaksi\KasController@store')->middleware(['auth'])->name('kas/store');
Route::get('/kas_validasi', 'App\Http\Controllers\FTransaksi\KasController@create_validasi')->middleware(['auth'])->name('kas_validasi');


Route::get('/kas/browse_bukti', 'App\Http\Controllers\FTransaksi\KasController@browse_bukti')->middleware(['auth'])->name('kas/browse_bukti');
 
Route::get('/rkas', 'App\Http\Controllers\FReport\RKasController@report')->middleware(['auth'])->name('rkas');
    // GET KAS
    Route::get('/get-kas', 'App\Http\Controllers\FTransaksi\KasController@getKas')->middleware(['auth'])->name('get-kas');
    Route::get('/get-kas-report', 'App\Http\Controllers\FReport\RKasController@getKasReport')->middleware(['auth'])->name('get-kas-report');
    Route::post('rkas/jasper-kas-report', 'App\Http\Controllers\FReport\RKasController@jasperKasReport')->middleware(['auth']);
// Dynamic Kas Masuk
Route::get('/kas/edit', 'App\Http\Controllers\FTransaksi\KasController@edit')->middleware(['auth'])->name('kas.edit');
Route::post('/kas/update/{kas}', 'App\Http\Controllers\FTransaksi\KasController@update')->middleware(['auth'])->name('kas.update');
Route::get('/kas/delete/{kas}', 'App\Http\Controllers\FTransaksi\KasController@destroy')->middleware(['auth'])->name('kas.delete');

// Operational Bank Masuk
Route::get('/bank', 'App\Http\Controllers\FTransaksi\BankController@index')->middleware(['auth'])->name('bank');
Route::post('/bank/store', 'App\Http\Controllers\FTransaksi\BankController@store')->middleware(['auth'])->name('bank/store');
Route::get('/rbank', 'App\Http\Controllers\FReport\RBankController@report')->middleware(['auth'])->name('rbank');
    // GET BANK
    Route::get('/get-bank', 'App\Http\Controllers\FTransaksi\BankController@getBank')->middleware(['auth'])->name('get-bank');
    Route::get('/get-bank-report', 'App\Http\Controllers\FReport\RBankController@getBankReport')->middleware(['auth'])->name('get-bank-report');
    Route::post('rbank/jasper-bank-report', 'App\Http\Controllers\FReport\RBankController@jasperBankReport')->middleware(['auth']);
    Route::get('/jasper-bank-trans/{bank:NO_ID}', 'App\Http\Controllers\FTransaksi\BankController@jasperBankTrans')->middleware(['auth']);
// Dynamic Bank Masuk
Route::get('/bank/edit', 'App\Http\Controllers\FTransaksi\BankController@edit')->middleware(['auth'])->name('bank.edit');
Route::post('/bank/update/{bank}', 'App\Http\Controllers\FTransaksi\BankController@update')->middleware(['auth'])->name('bank.update');
Route::get('/bank/delete/{bank}', 'App\Http\Controllers\FTransaksi\BankController@destroy')->middleware(['auth'])->name('bank.delete');




//Report
Route::post('/rmemo/cetak', 'App\Http\Controllers\FReport\RMemoController@cetak')->middleware(['auth'])->name('rmemo.cetak');













require __DIR__.'/auth.php';
