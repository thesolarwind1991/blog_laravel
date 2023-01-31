<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Post::all() as $post) {
            foreach (Tag::all() as $tag) {
                if (rand(1,20) == 10) {
                    $post->tags()->attach($tag->id);
                }
            }
        }
    }
}
