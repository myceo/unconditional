<?php
namespace App\Seeders;

use Illuminate\Database\Seeder;

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
        //     RoleTableSeeder::class,
        //     UserTableSeeder::class,
        //     SettingsTableSeeder::class
         ]);
    }
}
