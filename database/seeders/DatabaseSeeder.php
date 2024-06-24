<?php

namespace Database\Seeders;

use App\Models\MediaType;
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
            ContentSeeder::class,
            ContentTypeSeeder::class,
            ContentVisibilitySeeder::class,
            MediaTypeSeeder::class,
            NewsletterCampaignSeeder::class,
            UserSeeder::class,
        ]);
    }
}
