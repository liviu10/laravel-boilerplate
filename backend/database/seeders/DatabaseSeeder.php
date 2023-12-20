<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AcceptedDomainSeeder::class,
            ConfigurationColumnSeeder::class,
            ConfigurationInputSeeder::class,
            ConfigurationResourceSeeder::class,
            ConfigurationTypeSeeder::class,
            ContactSubjectSeeder::class,
            NewsletterCampaignSeeder::class,
            PermissionSeeder::class,
            ResourceChildrenSeeder::class,
            ResourceSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
