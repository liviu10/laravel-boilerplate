<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use Carbon\Carbon;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Application::truncate();
        $records = [
            [
                'id' => 1,
                'value' => 'is-blog',
                'label' => 'Blog',
                'description' => 'Set the application to be a blog',
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'value' => 'is-presentation',
                'label' => 'Presentation',
                'description' => 'Set the application to be a presentation',
                'is_active' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Application::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
