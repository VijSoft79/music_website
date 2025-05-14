<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Price;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

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
        $price = Price::first();
        $price->amount = $price->amount + 1;
        $price->save();
    }
}
