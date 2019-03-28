<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ranking as Ranking;
use DB;
use Storage;
use Slack;

class updateRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the ranking';

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

       $day = date('l');
       if( strtolower($day) == 'saturday' ) {
            $day = 'zaterdag';
       } elseif( strtolower($day) == 'sunday') {
            $day = 'zondag';
       }

       $exists = Storage::disk('local')->has('Uitslagen_Site.csv');
       if($exists) {
           
            $data = Storage::disk('local')->get('Standen_Site.csv');

            $csvFile = explode(PHP_EOL, $data);
            $data = [];
            $i = 0;
            foreach($csvFile as $line)
            {
                // Skip first row
                if($i != 0) {
                    array_push($data, explode(';', $line));
                }
                
                $i++;
            }

            foreach($data as $value)
            {
                if($value[1] != '0' || $value[1] != '..') {
                    Ranking::updateOrCreate(
                        [
                        'poule' => (isset($value[0]) ? $value[0] : ''),
                        'teams' => (isset($value[1]) ? $value[1] : '')
                        ],
                        [
                        'poule' => (isset($value[0]) ? $value[0] : ''),
                        'teams' => (isset($value[1]) ? $value[1] : ''),
                        'saldo' => (isset($value[2]) ? $value[2] : ''),
                        'punten' => (isset($value[3]) ? $value[3] : ''),
                        'plaats' => (isset($value[4]) ? str_replace('#NAME?', '0', $value[4]) : ''),
                        'dag' => (isset($value[5]) ? $value[5] : ''),
                        ]
                    );
                }
            }

            Storage::delete('Standen_Site.csv');

            DB::table('cron_updates')->insert([
                'programma' => '',
                'ranking' => 'Succesvol',
                'timestamp' => DB::raw('NOW()')
            ]);
           
            DB::table('stand')
                ->orderBy('id_stand', 'desc')
                ->limit(1)
                ->delete();
        
            Slack::send('Stand is succesvol geupdate!');
        }
    }
}
