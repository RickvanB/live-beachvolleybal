<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Programma as Programma;
use DB;
use Storage;
use Slack;

class updateProgramma extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:programma';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the program via a cronjob';

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

        // Check if file exists
        $exists = Storage::disk('local')->has('Uitslagen_Site.csv');
        if($exists) {

            // First, delete existing rows preventing duplicate entries in the database.
            //Programma::where('dag', 'zaterdag')->delete();

            // Get data from local storage that has been uploaded via FTP
            $data = Storage::disk('local')->get('Uitslagen_Site.csv');

            $csvFile = explode("\r\n", $data);
            $data = [];
            $i = 0;
            foreach ($csvFile as $line) 
            {
                // Skip first row
                if($i != 0) {
                    if($line == '0') {
                      continue;
                    }

                    array_push($data, explode(';', $line));
                }
                
                $i++;
            }

            foreach ($data as $value) 
            {
                // Check for empty row
                if($value[3] != '0' && $value[4] != '0') {
                    $dagdeel = strtolower($value[8]);

                    Programma::updateOrCreate(
                        [
                            'team1' => (isset($value[3]) ? $value[3] : ''),
                            'team2' => (isset($value[4]) ? $value[4] : ''),
                            'scheidsrechter' => (isset($value[5]) ? $value[5] : '')
                        ],
                        [
                            'ronde' => (isset($value[0]) ? str_replace('""', '', $value[0]) : ''),
                            'starttijd' => (isset($value[1]) ? str_replace('""', '', $value[1]) : ''),
                            'poule' => (isset($value[2]) ? str_replace('""', '', $value[2]) : ''),
                            'team1' => (isset($value[3]) ? str_replace('""', '', $value[3]) : ''),
                            'team2' => (isset($value[4]) ? str_replace('""', '', $value[4]) : ''),
                            'scheidsrechter' => (isset($value[5]) ? str_replace('""', '', $value[5]) : ''),
                            'uitslagen' => (isset($value[6]) ? str_replace('""', '', $value[6]) : ''),
                            'dag' => (isset($value[7]) ? str_replace('""', '', $value[7]) : ''),
                            'dagdeel' => (isset($dagdeel) ? str_replace('""', '', ucfirst($dagdeel)) : '')
                        ]
                    );
                }

                
            }

            Storage::delete('Uitslagen_Site.csv');

            DB::table('cron_updates')->insert([
                'programma' => 'Succesvol',
                'ranking' => '',
                'timestamp' => DB::raw('NOW()')
            ]);

            Slack::send('Programma is succesvol geupdate!');
        }
    }
}
