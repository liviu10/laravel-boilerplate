<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ContactSubject;
use Carbon\Carbon;

class ContactSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContactSubject::truncate();
        $records = [
            [
                'id'          => 1,
                "name"        => "Subject A",
                "description" => "Description for subject A",
                "is_active"   => true,
                "user_id"     => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 2,
                "name"        => "Subject B",
                "description" => "Description for subject B",
                "is_active"   => true,
                "user_id"     => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 3,
                "name"        => "Subject C",
                "description" => "Description for subject C",
                "is_active"   => true,
                "user_id"     => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ];
        ContactSubject::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
