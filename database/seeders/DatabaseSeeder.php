<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            // UserSeeder::class,
            RolesSeeder::class,
            // MetasDeProductoSeeder::class

        ]);

        // $user=User::find(1);
        // $user->assignRole('Admin');

    }
}
