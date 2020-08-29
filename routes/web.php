<?php

use Illuminate\Support\Facades\Route;
use App\Menu;
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

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/menu/makanan','MenuController@makanan');
// Route::get('/menu/minuman','MenuController@minuman');
Route::get('/menu',function(){
    $minuman = Menu::where('jenis', 'minuman')
    ->get();
    $makanan = Menu::where('jenis', 'makanan')
    ->get();
    $data=array(
        'jenis'=>'makanan',
        'minuman'=>$minuman,
        'makanan'=>$makanan
    );
    return view('menu')->with($data);
});
