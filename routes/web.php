<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
    return redirect('/menu');
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

Route::post('/menu/pesan',function(Request $request){
    // return $request->input('foo');
    // error_log($request->input('foo'));
    if (Auth::check()) {
        // The user is logged in...
        error_log("logged in already");
    }else{
        error_log("not logged in");
    }
    // foreach($request->input('pesanan') as $pesanan){
    //     error_log($pesanan);
    // }
    return "success";
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
