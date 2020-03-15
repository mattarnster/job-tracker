<?php

use Illuminate\Database\Seeder;
use \App\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            "name" => "Matt Arnold",
            "email" => "mattarnster.co.uk@gmail.com",
            "company" => "Absolute Unit Ltd"
        ]);
    }
}
