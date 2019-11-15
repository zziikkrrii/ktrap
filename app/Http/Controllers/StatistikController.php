<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\AktivitasSerangan;
use App\AttackerLogin;
use App\SeranganMasuk;
class StatistikController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index()
    {
        $jumlah_serangan = AttackerLogin::count();
        $serangan_berhasil = AttackerLogin::where('success',1)->count();
        $serangan_gagal = AttackerLogin::where('success',0)->count();
        $serangan_hariini = AttackerLogin::whereDate('timestamp',Carbon::today())->count();
        $total_input = AktivitasSerangan::count();
        $popular_command = AktivitasSerangan::where('input','LIKE',"%ls%")->count();
        $ip = SeranganMasuk::orderBy('starttime','desc')
            ->limit(10)
            ->get(['ip','starttime','level']); //semua tabel auth
        return view('dashboard.statistik',compact('jumlah_serangan','serangan_berhasil','serangan_gagal','serangan_hariini','total_input','popular_command','ip','starttime','level'));
    }

    protected function chart()
    {
        $result = AttackerLogin::selectRaw('DATE(timestamp) as Tanggal')
            ->whereBetween('timestamp', [Carbon::today()->subDays(10), NOW()])
            ->groupBy('Tanggal')
            ->selectRaw('count(*) as Jumlah')
            ->get();

        return response()->json($result);
    }

    protected function populer_cmd()
    {
        $populer_cmd = AktivitasSerangan::select('input')
            ->groupBy('input')
            ->selectRaw('count(*) as jumlah')
            ->orderBy('jumlah','desc')
            ->limit(5)
            ->get();
        return response()->json($populer_cmd);
    }

    protected function popular_cd()
    {
        $populer_cd = AktivitasSerangan::select('input')
            ->groupBy('input')
            ->where('input','like','%cd%')
            ->selectRaw('count(*) as jumlah')
            ->orderBy('jumlah','desc')
            ->limit(5)
            ->get();
        return response()->json($populer_cd);
    }

    protected function populer_ip()
    {
        $populer_ip = SeranganMasuk::select('ip')
            ->groupBy('ip')
            ->selectRaw('count(*) as jumlah')
            ->orderBy('jumlah','asc')
            ->limit(5)
            ->get();

        return response()->json($populer_ip);
    }

    protected function chartlogin()
    {
        $loginberhasil = AttackerLogin::select('success')
            ->where('success','0')
            ->count();
        $logingagal = AttackerLogin::select('success')
            ->where('success','1')
            ->count();

        $chartlogin = [$loginberhasil,$logingagal];
        return response()->json($chartlogin);
    }

    protected function most_uname()
    {
        $username = AttackerLogin::select('username')
                ->groupBy('username')
                ->selectRaw('count(*) as jml')
                ->orderBy('jml','asc')
                ->limit(5)
                ->get();
        return response()->json($username);
    }

    protected function most_pass()
    {
        $pass = AttackerLogin::select('password')
                ->groupBy('password')
                ->selectRaw('count(*) as jml')
                ->orderBy('jml','desc')
                ->limit(5)
                ->get();
        return response()->json($pass);
    }
}
