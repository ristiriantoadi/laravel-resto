<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    //
    public function makanan(){
        // return view('pages.about');
        $menus = Menu::where('jenis', 'makanan')
        ->get();
        // echo $menus;
        // exit();
        $data=array(
            'jenis'=>'makanan',
            'menus'=>$menus
        );
        return view('menu')->with($data);
    }

    public function minuman(){
        $menus = Menu::where('jenis', 'minuman')
               ->get();
               
        $data=array(
            'jenis'=>'minuman',
            'menus'=>$menus
        );
        return view('menu')->with($data);
    }
}
