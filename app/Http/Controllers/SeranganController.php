<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeranganMasuk;
use App\AttackerLogin;

class SeranganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    protected function index()
    { 
        $attacker = AttackerLogin::orderBy('timestamp','desc')
            ->orderBy('session','desc')
            ->get(); //semua tabel auth
        return view('dashboard.seranganmasuk',compact('attacker'));
    }

    protected function percobaan($session)
    {
        $percobaan = AttackerLogin::where('session',$session)
                    ->orderBy('timestamp','desc')
                    ->get(['username','password','success']);
        return view('dashboard.percobaan',compact('percobaan'));
    }

    protected function hapus()
    {
        AttackerLogin::truncate();
        return redirect()->back();   
    }
}
