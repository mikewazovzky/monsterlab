<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailDriver = config('mail.driver');
        config(['mail.driver' => 'log']);

        $this->call(UsersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);

        config(['mail.driver' => $mailDriver]);

        cache()->flush();
    }
}
