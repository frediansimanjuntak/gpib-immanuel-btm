<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin
        DB::table('users')->insert([
            'name' => "admin1",
            'email' => "admin1@admin.com",
            'password' => Hash::make('passwordadmin'),
            'role' => "1"
        ]);
    }
}
