<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CuratorCreateSpecialRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:curator-create-special-record';

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
        $userCurators = User::role('curator')->get();

        // dd($userCurators);
        foreach ($userCurators as $curators) {

            // dd(!$curators->special());
            if ($curators->special()->doesntExist()) {
                $curators->special()->create([
                    'user_id' => $curators, 
                    'is_special' => 1,            
                ]);
            }
            
        }
    }
}
