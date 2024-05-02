<?php

namespace Database\Seeder;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(50)->create();
    }
}