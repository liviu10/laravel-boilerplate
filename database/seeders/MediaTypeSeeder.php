<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MediaType;
use Carbon\Carbon;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        MediaType::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-images',
                'label' => 'Test images', // Live value: Images
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'test-documents',
                'label' => 'Test documents', // Live value: Documents
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'value' => 'test-videos',
                'label' => 'Test video', // Live value: Videos
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'value' => 'test-audio',
                'label' => 'Test audio', // Live value: Audio
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'value' => 'test-others',
                'label' => 'Test others', // Live value: Others
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        MediaType::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
