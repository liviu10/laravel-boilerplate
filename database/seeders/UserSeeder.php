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
                'full_name' => 'Briofresh Admin',
                'first_name' => 'Briofresh',
                'last_name' => 'Admin',
                'nickname' => 'briofresh_land',
                'email' => 'briofresh_admin@' . config('app.domain_name'),
                'phone' => '+40747339283',
                'email_verified_at' => null,
                'password' => bcrypt('123@UserWebmaster'),
                'profile_image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        User::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
