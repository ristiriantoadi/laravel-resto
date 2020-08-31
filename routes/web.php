<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Menu;
use App\Pembelian;
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

    $pembelian=[];
    if (Auth::check()) {
        error_log(Auth::user()->id);
        //get pembelian data
        $pembelian = Pembelian::where('user_id', Auth::user()->id)->get();
        // error_log(print_r($pembelian));
        // return $pembelian;
        foreach($pembelian as $p){
            error_log($p->menu_id);
        }
    }
    $minuman = Menu::where('jenis', 'minuman')
    ->get();

    foreach($minuman as $m){
        $m->count=0;
    }

    foreach($minuman as $m){
        // $m->diskon=false;
        foreach($pembelian as $p){
            if($m->id == $p->menu_id){
                    if($m->count == 0){
                        $m->harga = $m->harga-$m->harga*0.1;
                        $m->diskon=true;
                        $m->count=1;
                    }
            }
        }
    }

    $makanan = Menu::where('jenis', 'makanan')->get();

    foreach($makanan as $m){
        $m->count=0;
    }

    foreach($makanan as $m){
        foreach($pembelian as $p){
            if($m->id == $p->menu_id){
                if($m->count == 0){
                    $m->harga = $m->harga-$m->harga*0.1;
                    $m->diskon=true;
                    $m->count=1;
                }
        }
        }
    }

    $data=array(
        'jenis'=>'makanan',
        'minuman'=>$minuman,
        'makanan'=>$makanan
    );
    // return $makanan;
    return view('menu')->with($data);
});

Route::post('/menu/pesan',function(Request $request){
    // return $request->input('foo');
    // error_log($request->input('foo'));
    if (Auth::check()) {
        // The user is logged in...
        error_log("logged in already");
        
        $pesanans = $request->input('pesanan');
        foreach($pesanans as $pesanan){
            error_log($pesanan);
            DB::table('pembelians')->insert(
                ['user_id' => Auth::user()->id, 'menu_id' => $pesanan]
            );
        }
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
