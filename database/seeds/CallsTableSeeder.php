<?php

use Illuminate\Database\Seeder;

class CallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Customer::all()->each(function($customer){
            $customer->calls()
                ->saveMany(
                    factory(App\Call::class, 10)->make()
                );
        });
    }
}
