<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CommentStatus;
use Carbon\Carbon;

class CommentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        CommentStatus::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-pending',
                'label' => 'Test pending', // Live value: Pending
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'test-approved',
                'label' => 'Test approved', // Live value: Approved
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'value' => 'test-spam',
                'label' => 'Test spam', // Live value: Spam
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'value' => 'test-trash',
                'label' => 'Test trash', // Live value: Trash
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        CommentStatus::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
