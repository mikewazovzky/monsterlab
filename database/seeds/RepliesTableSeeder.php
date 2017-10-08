<?php

use App\Post;
use App\Reply;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class RepliesTableSeeder extends Seeder
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
            for ($i = 0; $i < 25; $i++) {
                Reply::create([
                    'user_id' => factory('App\User')->create()->id,
                    'post_id' => $post->id,
                    'body' => $faker->paragraph,
                ]);
            }
        });
    }
}
