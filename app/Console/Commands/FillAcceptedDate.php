<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;

use Carbon\Carbon;

class FillAcceptedDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-accepted-date';

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
        $offers = Offer::all();
        foreach ($offers as $offer) {
            if($offer->status > 0){
                $updatedAtDate = $offer->updated_at->toDateString();
                $offer->accepted_at =$updatedAtDate ;
                $offer->save();
            }
        }
    }
}
