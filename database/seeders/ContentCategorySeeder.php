<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ContentCategory;
use Carbon\Carbon;

class ContentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContentCategory::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-article',
                'label' => 'Test article',
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        ContentCategory::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
