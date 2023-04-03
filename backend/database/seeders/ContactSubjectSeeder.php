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
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContactSubject::truncate();
        $records = [
            [
                'id'         => 1,
                'title'      => 'Subject A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,
                'title'      => 'Subject B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,
                'title'      => 'Subject C',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        ContactSubject::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
