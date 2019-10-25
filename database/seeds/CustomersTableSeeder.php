<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Customer::class, 50)
            ->create(['typeable_type' => \App\Company::class]);

        factory(App\Customer::class, 50)
            ->create(['typeable_type' => \App\User::class]);

        \App\Customer::inRandomOrder()->limit(50)->each(function ($customer) {
            $customer->users()->sync(\App\User::inRandomOrder()->limit(rand(1,5))->get());
        });
    }
}
