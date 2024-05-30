<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ContentVisibility;
use Carbon\Carbon;

class ContentVisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContentVisibility::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-published',
                'label' => 'Test published', // Live value: Published
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'test-draft',
                'label' => 'Test draft', // Live value: Draft
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'value' => 'test-scheduled',
                'label' => 'Test scheduled', // Live value: Scheduled
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'value' => 'test-trashed',
                'label' => 'Test trashed', // Live value: Trashed
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        ContentVisibility::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
