<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\InvitationForChecking;

class MakeSampleLinkJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reports = InvitationForChecking::all();
        foreach($reports as $report){
            $url_array = [];
            array_push($url_array, $report->url);
            $report->url = json_encode($url_array);
            $report->save();
            $url_array = array();
        }
    }

    public function makeJson($urls){
        $url = json_encode($urls);
        return $url;
    }
}
