<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CommentStatusSeeder::class,
            CommentTypeSeeder::class,
            ContentCategorySeeder::class,
            ContactSubjectSeeder::class,
            ContentTypeSeeder::class,
            ContentVisibilitySeeder::class,
            NewsletterCampaignSeeder::class,
            UserSeeder::class,
        ]);
    }
}
