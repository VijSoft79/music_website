<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PageContent;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageContent::create([
            'title' => 'curator',
            'content' => '<p>Test</p>',
        ]);

        PageContent::create([
            'title' => 'musician',
            'content' => '<p>Test</p>',
        ]);
    }
}
