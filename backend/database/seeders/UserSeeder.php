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
                'id'                => '1',
                'full_name'         => 'User Webmaster',
                'first_name'        => 'User',
                'last_name'         => 'Webmaster',
                'nickname'          => 'webmaster',
                'email'             => 'webmaster@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'user_role_type_id' => '1',
                'password'          => bcrypt('123@UserWebmaster'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]
        ];
        User::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
