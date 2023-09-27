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
                'id'                => 1,
                'full_name'         => 'User Webmaster',
                'first_name'        => 'User',
                'last_name'         => 'Webmaster',
                'nickname'          => 'webmaster',
                'email'             => 'webmaster@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 1,
                'password'          => bcrypt('123@UserWebmaster'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 2,
                'full_name'         => 'User Administrator',
                'first_name'        => 'User',
                'last_name'         => 'administrator',
                'nickname'          => 'administrator',
                'email'             => 'administrator@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 2,
                'password'          => bcrypt('123@UserAdministrator'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 3,
                'full_name'         => 'User Editor',
                'first_name'        => 'User',
                'last_name'         => 'Editor',
                'nickname'          => 'editor',
                'email'             => 'editor@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 3,
                'password'          => bcrypt('123@UserEditor'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 4,
                'full_name'         => 'User Author',
                'first_name'        => 'User',
                'last_name'         => 'Author',
                'nickname'          => 'author',
                'email'             => 'author@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 4,
                'password'          => bcrypt('123@UserAuthor'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 5,
                'full_name'         => 'User Contributor',
                'first_name'        => 'User',
                'last_name'         => 'Contributor',
                'nickname'          => 'contributor',
                'email'             => 'contributor@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 5,
                'password'          => bcrypt('123@UserContributor'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 6,
                'full_name'         => 'User Subscriber',
                'first_name'        => 'User',
                'last_name'         => 'Subscriber',
                'nickname'          => 'subscriber',
                'email'             => 'subscriber@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 6,
                'password'          => bcrypt('123@UserSubscriber'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 7,
                'full_name'         => 'User Accountant',
                'first_name'        => 'User',
                'last_name'         => 'Accountant',
                'nickname'          => 'accountant',
                'email'             => 'accountant@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 7,
                'password'          => bcrypt('123@UserAccountant'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 8,
                'full_name'         => 'User Sales',
                'first_name'        => 'User',
                'last_name'         => 'Sales',
                'nickname'          => 'sales',
                'email'             => 'sales@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 8,
                'password'          => bcrypt('123@UserSales'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 9,
                'full_name'         => 'User Client',
                'first_name'        => 'User',
                'last_name'         => 'Client',
                'nickname'          => 'client',
                'email'             => 'client@' . config('app.domain_name'),
                'email_verified_at' => Carbon::now(),
                'phone'             => null,
                'role_id'           => 9,
                'password'          => bcrypt('123@UserClient'),
                'profile_image'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]
        ];
        User::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
