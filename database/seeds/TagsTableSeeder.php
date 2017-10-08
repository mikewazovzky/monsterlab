<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tag::class)->create(['name' => 'PHP']);
        factory(App\Tag::class)->create(['name' => 'Laravel']);
        factory(App\Tag::class)->create(['name' => 'JavaScript']);
        factory(App\Tag::class)->create(['name' => 'ES6']);
        factory(App\Tag::class)->create(['name' => 'Vue']);
    }
}
