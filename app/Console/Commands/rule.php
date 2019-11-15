<?php

namespace App\Console\Commands;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Console\Command;
use App\AktivitasSerangan;
use App\DangerCommand;
use App\SeranganMasuk;
use App\AttackerLogin;

class rule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rule:level';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rule level serangan';

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
    public function handle()
    {
        $attacker  = SeranganMasuk::orderBy('starttime','desc')
                    ->get();
        $login     = AttackerLogin::where('success',1)
                    ->get();
        $danger    = collect(['wget','adduser','rm','userdell','passwd','apt-get','nano']);
        
        //Rule Level 2
        foreach ($attacker as $at){
            foreach ($login as $lg){
                if ($lg->session == $at->id_session){
                    SeranganMasuk::where('id_session',$at->id_session)
                                ->update(['level'=>2]);
                    $command   = AktivitasSerangan::where('session',$at->id_session)
                                ->get(['input']);
                    //Rule Level 3
                    foreach ($command as $c){
                        foreach ($danger as $d) {
                            if (preg_match("/$d/",$c)){
                                SeranganMasuk::where('id_session',$at->id_session)
                                        ->update(['level'=>3,'updated_at'=>NOW()]);
                            }
                        }
                    }
                }
            }
        }
    }
}