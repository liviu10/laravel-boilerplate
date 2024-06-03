<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        $records = [
            [
                'id' => 1,
                'full_name' => 'User Webmaster',
                'first_name' => 'User',
                'last_name' => 'Webmaster',
                'nickname' => null,
                'email' => 'webmaster@' . config('app.domain_name'),
                'phone' => null,
                'email_verified_at' => null,
                'password' => bcrypt('123@UserWebmaster'),
                'profile_image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'full_name' => 'Job Queue',
                'first_name' => 'Job',
                'last_name' => 'Queue',
                'nickname' => null,
                'email' => 'job_queue@' . config('app.domain_name'),
                'phone' => null,
                'email_verified_at' => null,
                'password' => bcrypt('123@JobQueue'),
                'profile_image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        User::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
