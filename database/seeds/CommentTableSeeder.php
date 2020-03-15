<?php

use Illuminate\Database\Seeder;
use \App\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            "job_id" => 1,
            "user_id" => 1,
            "comment" => "This is a comment"
        ]);
    }
}
