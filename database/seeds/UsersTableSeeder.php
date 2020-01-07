<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\User::class)->create([
            'name' => 'Admin Admin',
            'email' => 'admin@lt.coop.br',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'is_admin' => true,
        ]);

        factory(App\User::class, 9)->create();
    }
}
