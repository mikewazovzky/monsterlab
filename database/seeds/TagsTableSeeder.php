<?php

use MWazovzky\Taggable\Tag;
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
        factory(Tag::class)->create(['name' => 'PHP']);
        factory(Tag::class)->create(['name' => 'Laravel']);
        factory(Tag::class)->create(['name' => 'JavaScript']);
        factory(Tag::class)->create(['name' => 'ES6']);
        factory(Tag::class)->create(['name' => 'Vue']);
    }
}
