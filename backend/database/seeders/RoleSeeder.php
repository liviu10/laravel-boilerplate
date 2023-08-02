<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Role::truncate();
        $records = [
            [
                'id'          => 1,
                'name'        => 'Webmaster',
                'description' => 'A user with access to the website network administration features and all other features that are included for the rest of the user role types (administrator, author, editor, contributor and subscriber).',
                'bg_color'    => '007BFF',
                'text_color'  => 'FFFFFF',
                'slug'        => 'webmaster',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 2,
                'name'        => 'Administrator',
                'description' => 'A user with access to all the administration features withing a single website and all other features that are included for the rest of the user role types (author, editor, contributor and subscriber).',
                'bg_color'    => '17A2B8',
                'text_color'  => '000000',
                'slug'        => 'administrator',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 3,
                'name'        => 'Accountant',
                'description' => 'Accountant is the user role for your accounting or bookkeeping staff. They will have the ability to enter journal entries, closing dates and password, access to the chart of accounts and all accountant/taxes and company financial reporting.',
                'bg_color'    => '28A745',
                'text_color'  => '000000',
                'slug'        => 'accountant',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 4,
                'name'        => 'Sales',
                'description' => 'Sales is a role designed for the staff member that needs access to sales orders, sales receipts, sales reports, estimates, and all information in the customer list.',
                'bg_color'    => 'FFC107',
                'text_color'  => '000000',
                'slug'        => 'sales',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 5,
                'name'        => 'Client',
                'description' => 'Assigned to new customers when they create an account on your website. This role is basically equivalent to that of a normal blog subscriber, but customers can edit their own account information and view past or current orders.',
                'bg_color'    => 'DC3545',
                'text_color'  => '000000',
                'slug'        => 'client',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ];
        Role::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
