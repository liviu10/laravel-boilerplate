<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ContentType;
use Carbon\Carbon;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContentType::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-page',
                'label' => 'Test page', // Live value: Page
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'test-article',
                'label' => 'Test article', // Live value: Article
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        ContentType::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
