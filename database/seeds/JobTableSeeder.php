<?php

use Illuminate\Database\Seeder;

use \App\Job;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create([
            "name" => "Trailer Repair",
            "customer_id" => 1,
            "status" => "received",
            "assigned_to" => 1,
            "specification" => "This is a specification."
        ]);
    }
}
