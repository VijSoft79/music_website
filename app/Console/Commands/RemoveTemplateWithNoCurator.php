<?php

namespace App\Console\Commands;

use App\Models\Offer;
use App\Models\OfferTemplate;
use Illuminate\Console\Command;


class RemoveTemplateWithNoCurator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-templates';

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
        $template = OfferTemplate::all();
        foreach ($template as $templates) {

            if ($templates->curator == null) {
                $templates->delete(); 
                echo $templates->id . "\n";
            }else{
                echo "no data to be deleted";
            }
            
        }
        
    }
}
