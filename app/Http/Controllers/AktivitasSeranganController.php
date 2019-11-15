<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AktivitasSerangan;
use App\SeranganMasuk;

class AktivitasSeranganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

	protected function index()
	{
        $semua_aktivitas = AktivitasSerangan::select()
                        ->orderBy('timestamp','asc')
                        ->get();
		return view('dashboard.semua_aktivitas',compact('semua_aktivitas'));
	}

	
    protected function session($session)
    {
		$aktivitas = AktivitasSerangan::where('session',$session)
            ->get(['input','success','timestamp']);
        
        $ip =  SeranganMasuk::where('id_session',$session)
            ->get(['ip']);
        return view('dashboard.aktivitas_serangan',compact('aktivitas','ip'));

    }
    
    protected function hapus()
    {
        AktivitasSerangan::truncate();
        return redirect()->back();
    }
}
