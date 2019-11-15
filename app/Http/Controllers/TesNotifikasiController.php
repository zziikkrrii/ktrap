<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;
use App\SeranganMasuk;
// use App\LogNotifikasi;

class TesNotifikasiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    protected function index()
    {
        $log_notifikasi = SeranganMasuk::orderBy('starttime','desc')
            ->get();
        return view('dashboard.notifikasi',compact('log_notifikasi'));
        
    }

    protected function tes()
    {
        $text = "<b>Test Notifikasi Berhasil</b>\n"
            . "\n"
            . "Pesan diterima Pada : "
            . NOW();

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001198254211.0'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        
        SeranganMasuk::insert(['id_session'=>'TESTING','ip'=>'TESTING','level'=>'TEST','starttime'=>NOW(),'notif'=>'1']);

        return redirect()->back();   
    }

    protected function hapus($id)
    {
        SeranganMasuk::where('id',$id)
                    ->delete();

        return redirect()->back();   
    }
    
}
