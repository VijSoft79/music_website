<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Normal Curator',
            'email' => 'normalcurator@youhearus.com',
            'password' => Hash::make('password')
        ])->assignRole('curator')->givePermissionTo('can use all');

        User::create([
            'name' => 'SpecialCurator',
            'email' => 'specialcurator@youhearus.com',
            'password' => Hash::make('password')
        ])->assignRole('curator')->givePermissionTo('can use all');

        $musician = User::create([
            'name' => 'Musician',
            'email' => 'musician@youhearus.com',
            'password' => Hash::make('password')
        ])->assignRole('musician')->givePermissionTo('can use all');

        $musician->music()->create([
            'title' => 'Test Song',
            'user_id' => $musician->id,
            'genre' => json_encode(['2']),
            'release_date' => '2024-02-01',
            'release_type' => 'single',
            'song_version' => 'cover',
            'note' => 'lorem ipsum dolor',
            'description' => 'lorem ipsum dolor',
            'embeded_url' => '<iframe width="1280" height="720" src="https://www.youtube.com/embed/uWFCye7C6Qk" title="Background Music for Live Streaming (3 Hours No Copyright Music)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'status' => 1,
            'image_url' => 'images/headshot.jpg'
        ]);

    }
}
