<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeranganMasuk;
use App\AttackerLogin;
use App\AktivitasSerangan;

class IPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $level1 = SeranganMasuk::where('level',1)
                ->count('level');
        $level2 = SeranganMasuk::where('level',2)
                ->count('level');
        $level3 = SeranganMasuk::where('level',3)
                ->count('level');
        $ip = SeranganMasuk::orderBy('starttime','desc')
            ->get(['id_session','starttime','ip','level']); //semua tabel auth
        return view('dashboard.sesion',compact('ip','level1','level2','level3'));
    }

    protected function hapus()
    {
        SeranganMasuk::truncate();
        return redirect()->back();   
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_session)
    {
        //
        SeranganMasuk::where('id_session',$id_session)
                    ->delete();
        AttackerLogin::where('session',$id_session)
                    ->delete();
        AktivitasSerangan::where('session',$id_session)
                    ->delete();
        return redirect()->back();   
    }
}
