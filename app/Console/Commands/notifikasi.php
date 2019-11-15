<?php

namespace App\Console\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Console\Command;
use App\SeranganMasuk;


class notifikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do:notif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi Otomatis jika terjadi serangan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $penyerang  = SeranganMasuk::orderBy('starttime')
                        ->get();
        foreach ($penyerang as $p){
            if ($p->notif !== $p->level){
                $text = "<b>Serangan baru Telah Masuk!!!</b>\n"
                . "\n IP Penyerang: "
                . $p->ip
                . "\n\n"
                . "Serangan masuk pada: "
                . $p->starttime
                . "\n\nLevel Serangan: "
                . $p->level
                . "\n\n";
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001198254211.0'),
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
                SeranganMasuk::where('id_session',$p->id_session)
                            ->update(['notif'=>$p->level,'updated_at'=>NOW()]);
            }
        }
    }
}