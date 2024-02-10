<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Add dummy data for locale
     * Seed the application's database.
     */
    public function run(): void
    {

        /*User::truncate();
        Category::truncate();
        Post::truncate();*/

        $user = User::factory()->create([
            'name' => 'Sooraj Malhi'
        ]);

        //Post::factory(5)->create(); // create 5 posts with new user and category

        // Create 5 post with 5 different categories, but assign the same user
        Post::factory(5)->create([
            'user_id' => $user->id
        ]);
    }
}
