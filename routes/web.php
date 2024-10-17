<?php


use App\Models\CalegProv;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardTim;
use App\Http\Controllers\DptController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\DashboardCaleg;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DptTimController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\DptCalegController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RelawantimController;
use App\Http\Controllers\TargetCalegController;
use App\Http\Controllers\PendukungTimController;
use App\Http\Controllers\PendukungCalegController;
use App\Http\Controllers\KlasifikasiBantuanController;
use App\Http\Controllers\KlasifikasiPendukungController;

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

Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');
// ada perubahan php munfo
// admin system
Route::redirect('/', '/login');

Route::redirect('/home', '/welcome');

Route::get(
    '/welcome',
    function () {
        $level_caleg = session()->get('level_caleg');
        $caleg_id = session()->get('caleg_id');

        if ($level_caleg == 2) {
            $profil_caleg = CalegProv::with('partai', 'dapil')->where('id', $caleg_id)->first();
        } else {
            $profil_caleg = null;
        }

        return view('welcome', [
            'title' => 'Welcome',
            'profil_caleg' => $profil_caleg,
        ]);
    }
)->middleware('auth');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'auth');
    Route::post('/logout', 'logout');
});

Route::controller(ProfilController::class)->middleware('auth')->group(function () {
    Route::get('/profil/{user}', 'show');
    Route::get('/profil/{user}/edit', 'edit');
    Route::put('/profil/{user}', 'update');
});

Route::resource('/calon', CalonController::class)->middleware('isAdmin')->except(['destroy', 'show']);

Route::controller(DptController::class)->middleware('isAdmin')->group(function () {
    Route::get('/dpt', 'index');
    Route::get('/dpt/create', 'create');
    Route::post('/dpt', 'store');

    Route::get('/get_kecamatan/dpt/{id}', 'getKecamatan');
    Route::get('/get_kelurahandesa/dpt/{id}', 'getKelurahanDesa');
    Route::get('/get_kelurahandesaimport/dpt/{id}', 'getKelurahanDesaImport');
    Route::get('/get_tps/dpt/{id}', 'getTps');

    // Route::get('/dpt/cek_total/{kabkota}', 'cek_total');
    // Route::get('/dpt/update_total_kecamatan/', 'update_total_kecamatan');
    // Route::get('/dpt/update_total_kabkota/', 'update_total_kabkota');

});


// admin system

//admin calon
Route::controller(DptCalegController::class)->middleware('isCaleg')->group(function () {
    // Route::get('/dptcaleg', 'index');
    // Route::get('/dptcaleg/dash', 'dashboard');

    Route::get('/collectdata', 'index');
    Route::get('/collectdata/dash', 'dashboard');

    Route::get('/collectdata/create', 'create');
    Route::post('/collectdata', 'store');


    Route::get('/get_kecamatan/dptcaleg/{id}', 'getKecamatan');
    Route::get('/get_kelurahandesa/dptcaleg/{id}', 'getKelurahanDesa');
    Route::get('/get_tps/dptcaleg/{id}', 'getTps');
});

Route::controller(PendukungCalegController::class)->middleware('isCaleg')->group(function () {
    Route::get('/pendukung/dash', 'dashboard');
    Route::get('/pendukung/index', 'index');

    Route::get('/pendukung/create/{id_dpt}/{status}', 'create');
    Route::post('/pendukung', 'store');

    Route::get('/pendukung_referensi/create/{id_dpt}/{status}', 'create_referensi');
    Route::post('/pendukung_referensi', 'store_referensi');
    Route::get('/pendukung_daftar_referensi/{id}', 'daftar_referensi');

    Route::get('/pendukung/pilih_print', 'pilih_print');

    Route::get('/pendukungg/form_destroy/{id_dpt}', 'form_destroy');
    Route::delete('/pendukung/{id}', 'destroy');
});

Route::resource('/klasifikasipendukung', KlasifikasiPendukungController::class)->middleware('isCaleg')->except(['destroy', 'show'])->parameters([
    'KlasifikasiPendukung' => 'KlasifikasiPendukung',
]);

Route::resource('/klasifikasibantuan', KlasifikasiBantuanController::class)->middleware('isCaleg')->except(['destroy', 'show'])->parameters([
    'KlasifikasiBantuan' => 'KlasifikasiBantuan',
]);

Route::resource('/tim', TimController::class)->middleware('isCaleg')->except(['destroy', 'show'])->parameters([
    'tim' => 'tim',
]);

Route::resource('/dataprovider', RelawanController::class)->middleware('isCaleg')->except(['destroy'])->parameters([
    'dataprovider' => 'dataprovider',
]);

Route::controller(TargetCalegController::class)->middleware('isCaleg')->group(function () {
    Route::get('/target/edit', 'edit');
    Route::put('/target', 'update');
});

Route::controller(DashboardCaleg::class)->middleware('isCaleg')->group(function () {
    Route::get('/dash', 'index');
});

Route::resource('/operator', OperatorController::class)->middleware('isCaleg')->except(['destroy'])->parameters([
    'operator' => 'operator',
]);

// admin calon

// tim calon

// Route::controller(DashboardTim::class)->middleware('isTim')->group(function () {
//     Route::get('/timdash', 'index');
// });


Route::controller(DptTimController::class)->middleware('isTim')->group(function () {
    Route::get('/timdpt', 'index');

    Route::get('/get_kecamatan/timdpt/{id}', 'getKecamatan');
    Route::get('/get_kelurahandesa/timdpt/{id}', 'getKelurahanDesa');
    Route::get('/get_tps/timdpt/{id}', 'getTps');
});

Route::controller(PendukungTimController::class)->middleware('isTim')->group(function () {
    Route::get('/pendukung_tim/create/{id_dpt}/{status}', 'create');
    Route::post('/pendukung_tim', 'store');

    Route::get('/pendukung_referensi_tim/create/{id_dpt}/{status}', 'create_referensi');
    Route::post('/pendukung_referensi_tim', 'store_referensi');
});

Route::resource('/dataprovidertim', RelawantimController::class)->middleware('isTim')->except(['destroy'])->parameters([
    'dataprovidertim' => 'dataprovidertim',
]);




// tim calon
