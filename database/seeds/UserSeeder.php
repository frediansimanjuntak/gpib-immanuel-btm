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
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make('passwordadmin'),
            'role' => "2"
        ]);

        DB::table('activities')->insert([
            'name' => "Ibadah Umum Batu Ampar",
            'description' => "Ibadah umum hari minggu di batu ampar",
            'confirmed' => true
        ]);
    }
}
