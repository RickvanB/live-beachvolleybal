<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use App\Http\Controllers\ApiController as VCB_API;

class Kernel extends ConsoleKernel
{

    private $api;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\updateProgramma::class,
        Commands\updateRanking::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        
        // Updating the program.
        if($this->isCheckboxAssigned() == '1')
        {
            $schedule->command('update:programma')->everyThirtyMinutes()->withoutOverlapping();
            $schedule->command('update:ranking')->everyThirtyMinutes()->withoutOverlapping();

            $message = 'De uitslagen en de standen van uw team zijn bijgewerkt!';
            $this->notification($message);
        }
        
        // Check for queues
        $schedule->command('queue:work')->everyMinute()->withoutOverlapping();
        
        // Backup and monitor Laravel
        $schedule->command('backup:monitor')->daily()->at('10:00');
        $schedule->command('backup:run --only-to-disk=dropbox')->daily();
        $schedule->command('backup:run --only-db --only-to-disk=dropbox')->everyThirtyMinutes();
        $schedule->command('backup:clean')->weekly();
    }

    /**
     * Send notification to users
     * @param  string $message 
     * @return json
     */
    private function notification($message = NULL)
    {
        // Instantiate API class
        $this->api = new VCB_API;

        $endpoint = '/notifications/send';
        $type = 'post';
        $fields = array('message' => $message);
        $result = $this->api->apiCall($endpoint, $type, null, $fields);
        return $result;
    }

    private function isCheckboxAssigned()
    {
        $checkbox = DB::table('backend')
                    ->select('automatic_updates')
                    ->get();

        if(empty($checkbox))
        {
            $checkbox = '';
        }
        else
        {
            $checkbox = $checkbox[0]->automatic_updates;
        }

        return $checkbox;
    }
}
