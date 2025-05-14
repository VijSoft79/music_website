<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EmailMessage;

class EmailMessages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailMessages::create([
            'title' => 'Email to Admin',
            'email_type' => 'registration notif',
            'content' => '<p>Test</p>',
            'email_to' => 'admin',
        ]);

        EmailMessages::create([
            'title' => 'Email to curator',
            'email_type' => 'registration notif to curator',
            'content' => '<p>Test</p>',
            'email_to' => 'curator',
        ]);
    }
}
