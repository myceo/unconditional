<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::insert([
            [
                'title'=>'admin',
            ],
            [
                'title'=>'subscriber'
            ]
        ]);
    }
}
