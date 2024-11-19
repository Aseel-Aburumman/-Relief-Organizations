<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // إضافة بوستات تجريبية
        Post::create([
            'title' => 'First Post',
            'content' => 'This is the content of the first post.',
            'lang_id' => 1,
        ]);

      
    }
}

