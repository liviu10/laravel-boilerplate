<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CommentType;
use Carbon\Carbon;

class CommentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        CommentType::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'test-comment',
                'label' => 'Test comment', // Live value: Comment
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'test-reply',
                'label' => 'Test reply', // Live value: Reply
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        CommentType::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
