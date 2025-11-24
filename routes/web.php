<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[DashboardController::class,'index'] );
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
Route::resource('/profiles' , App\Http\Controllers\ProfilesController::class);
Route::post('/confirmDelProfile' , [App\Http\Controllers\ProfilesController::class , 'confirmDelProfile']);
Route::resource('/chemicalgroups' , App\Http\Controllers\ChemicalGroupController::class);
Route::post('/confirmDelChemicalGroup' , [App\Http\Controllers\ChemicalGroupController::class , 'confirmDelChemicalGroup']);
Route::post('/getData-ChemicalGroup' , [App\Http\Controllers\ChemicalGroupController::class , 'getDataChemicalGroup']);
Route::post('/confirmDelChemicalFuntion' , [App\Http\Controllers\ChemicalGroupController::class , 'confirmDelChemicalFuntion']);
Route::resource('/chemicallists' , App\Http\Controllers\ChemicalListController::class);
Route::post('/confirmDelChemical' , [App\Http\Controllers\ChemicalListController::class , 'confirmDelChemical']);
Route::get('/chemical/functions/{group_id}', [App\Http\Controllers\ChemicalListController::class, 'getFunctions']);
