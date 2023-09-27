<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Unidad\UnidadController;
use App\Http\Controllers\Periodo\PeriodoController;
use App\Http\Controllers\Dependencia\DependenciaController;
use App\Http\Controllers\Metas\EvidenciasController;
use App\Http\Controllers\Metas\HojaDeVidaController;
use App\Http\Controllers\Metas\MetasController;
use App\Http\Controllers\Metas\ReportesController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Permisos\PermisosController;
use App\Http\Controllers\Programacion\EstrategiaController;
use App\Http\Controllers\Programacion\HechoController;
use App\Http\Controllers\Programacion\PoliticaController;
use App\Http\Controllers\Programacion\ProgramaController;
use App\Http\Controllers\Proyecto\ProyectoMovimientosFinancierosController;
use App\Http\Controllers\Proyecto\ProyectoPresupuestosController;
use App\Http\Controllers\Proyecto\ProyectoProductosController;
use App\Http\Controllers\Proyecto\ProyectosController;
use App\Models\Periodo;
use App\Models\User;
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


Route::get('/test', function () {
    $user = User::find(1);
    $user->password = '12345';
    $user->save();
    return $user;
});
Route::get('/test1', function () {
    return $data = Periodo::where('estado', 'activo')
        ->with(['users' => function ($query) {
            $query->where('user_id', 1);
        }])
        ->first();
});
// Main Page Route

Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::redirect('/', '/login', 301);

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'log'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    //User
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home-index');
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user.index');
        Route::post('/store', 'store')->name('user.store');
        Route::get('/get', 'get')->name('user.get');
        Route::get('/delete/{user}', 'delete')->name('user.delete');
        Route::post('/update/{user}', 'update')->name('user.update');
        Route::get('/getData/{user}', 'getData')->name('user.get.data');
    });
    //Dependencia
    Route::prefix('dependencia')->controller(DependenciaController::class)->group(function () {
        Route::get('/', 'index')->name('dependencias.index');
        Route::post('/store', 'store')->name('dependencia.store');
        Route::get('/get', 'get')->name('dependencia.get');
        Route::get('/delete/{dependencia}', 'delete')->name('dependencia.delete');
        Route::post('/update/{dependencia}', 'update')->name('dependencia.update');
        Route::get('/getData/{dependencia}', 'getData')->name('dependencia.get.data');
    });
    //Periodo
    Route::prefix('periodo')->controller(PeriodoController::class)->group(function () {
        Route::get('/', 'index')->name('periodo.index');
        Route::post('/store', 'store')->name('periodo.store');
        Route::post('/asignar', 'asignar')->name('periodo.asignar');
        Route::get('/get', 'get')->name('periodo.get');
        Route::get('/get-by-user', 'getUserPeriodo')->name('periodo.get.user.periodo');
        Route::get('/delete/asignacion/{relacion}', 'deleteAsignacion')->name('periodo.delete.asignacion');
        Route::get('/delete/{periodo}', 'delete')->name('periodo.delete');
        Route::post('/update/{periodo}', 'update')->name('periodo.update');
        Route::get('/getData/{periodo}', 'getData')->name('periodo.get.data');
    });
    //Unidad de Medida
    Route::prefix('unidad')->controller(UnidadController::class)->group(function () {
        Route::get('/', 'index')->name('unidad.index');
        Route::post('/store', 'store')->name('unidad.store');
        Route::get('/get', 'get')->name('unidad.get');
        Route::get('/delete/{unidad}', 'delete')->name('unidad.delete');
        Route::post('/update/{unidad}', 'update')->name('unidad.update');
        Route::get('/getData/{unidad}', 'getData')->name('unidad.get.data');
    });
    //Roles
    Route::prefix('roles')->controller(RolesController::class)->group(function () {
        Route::get('/', 'index')->name('roles.index');
        Route::post('/store', 'store')->name('roles.store');
        Route::get('/get', 'get')->name('roles.get');
        Route::get('/delete/{roles}', 'delete')->name('roles.delete');
        Route::post('/update/{roles}', 'update')->name('roles.update');
        Route::get('/getData/{roles}', 'getData')->name('roles.get.data');
    });
    //Permisos
    Route::prefix('permisos')->controller(PermisosController::class)->group(function () {
        Route::get('/', 'index')->name('permisos.index');
        Route::post('/store', 'store')->name('permisos.store');
        Route::get('/get', 'get')->name('permisos.get');
        Route::get('/delete/{permisos}', 'delete')->name('permisos.delete');
        Route::post('/update/{permisos}', 'update')->name('permisos.update');
        Route::get('/getData/{permisos}', 'getData')->name('permisos.get.data');
    });

    // metas
    Route::prefix('metas')->group(function () {
        Route::get('/', [MetasController::class, 'index'])->name('metas.index');
        Route::get('/ejecucion', [MetasController::class, 'indexEjecucion'])->name('metas.ejecucion.index');
        Route::get('/get', [MetasController::class, 'get'])->name('metas.get');
        Route::post('/getAll', [MetasController::class, 'indexData'])->name('metas.getAll');
        Route::get('/indicadores', [MetasController::class, 'getIndicadores'])->name('indicadores.get');
        Route::post('/', [MetasController::class, 'store'])->name('metas.store');
        Route::put('/{meta}', [MetasController::class, 'update'])->name('metas.update');
        Route::delete('/{meta}', [MetasController::class, 'destroy'])->name('metas.destroy');
        
        // Rutas para Reportes de Metas
        Route::prefix('reportes')->group(function (){
            Route::get('/{meta}', [ReportesController::class, 'index'])->name('metas.reportes.index');
            Route::get('/getData/{meta}', [ReportesController::class, 'indexData'])->name('metas.reportes.indexData');
            Route::get('/get/{id}', [ReportesController::class, 'show'])->name('metas.reportes.get');
            Route::post('/store', [ReportesController::class, 'store'])->name('metas.reportes.store');
            Route::put('/store/{id}', [ReportesController::class, 'update'])->name('metas.reportes.update');
            Route::delete('/{reporte}', [ReportesController::class, 'destroy'])->name('metas.reportes.destroy');
        });

        // Rutas para Evidencias de Metas
        Route::prefix('evidencias')->group(function (){
            Route::get('/{reporte}', [EvidenciasController::class, 'show'])->name('metas.evidencias.show');
            Route::post('/', [EvidenciasController::class, 'store'])->name('metas.evidencias.store');
            Route::delete('/{evidencia}', [EvidenciasController::class, 'destroy'])->name('metas.evidencias.destroy');
            Route::get('/download/{id_file}', [EvidenciasController::class, 'descargar'])->name('metas.evidencias.download');
        });

        // Rutas para Hoja de Vida de Metas
        Route::prefix('hoja-vida')->group(function (){
            Route::post('/', [HojaDeVidaController::class, 'store'])->name('metas.hoja-vida.store');
            Route::put('/{id}', [HojaDeVidaController::class, 'update'])->name('metas.hoja-vida.update');
        });
    });

    Route::get('/resultados', function () {
        return view('resultados.index');
    })->name('resultados');


    Route::resource('hechos', HechoController::class);
    Route::get('/hechos-get', [HechoController::class, 'get'])->name('hechos.get');

    Route::resource('politicas', PoliticaController::class);
    Route::get('/politicas-get', [PoliticaController::class, 'get'])->name('politicas.get');

    Route::resource('estrategias', EstrategiaController::class);
    Route::get('/estrategias-get', [EstrategiaController::class, 'get'])->name('estrategias.get');

    Route::resource('programas', ProgramaController::class);
    Route::get('/programas-get', [ProgramaController::class, 'get'])->name('programas.get');


    //plan operativo anual
    Route::resource('proyectos', ProyectosController::class);
    Route::get('/proyectos-get', [ProyectosController::class, 'get'])->name('proyectos.get');
    Route::get('/proyectos-get-all/{id}', [ProyectosController::class, 'getAll'])->name('proyectos.get.all');

    Route::resource('proyectos-productos', ProyectoProductosController::class);
    Route::post('/save-porcentaje-metas', [ProyectoProductosController::class, 'savePorcentajesMetas'])->name('savePorcentajesMetas');

    Route::resource('proyecto-presupuestos', ProyectoPresupuestosController::class);
    Route::get('/get-presupuesto/{id}', [ProyectoPresupuestosController::class, 'getPresupuesto'])->name('proyecto-presupuestos.getPresupuesto');

    Route::resource('proyectos-movimientos', ProyectoMovimientosFinancierosController::class);
});
