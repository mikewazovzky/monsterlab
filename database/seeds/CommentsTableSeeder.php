<?php

use App\Post;
use App\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        Post::all()->each(function ($post) use ($faker) {
            for ($i = 0; $i < 5; $i++) {
                Comment::create([
                    'user_id' => factory('App\User')->create()->id,
                    // 'post_id' => $post->id,
                    'commentable_id' => $post->id,
                    'commentable_type' => 'App\Post',
                    'body' => $faker->paragraph,
                ]);
            }
        });
    }
}
