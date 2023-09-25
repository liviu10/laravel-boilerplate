<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
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
                'name'        => 'Editor',
                'description' => 'Editors have the ability to manage and publish all posts and pages on the blog. They can also moderate and edit comments, manage categories and tags, and work on the content submitted by authors and contributors. Editors do not have access to site settings or plugin/theme management.',
                'bg_color'    => '28A745',
                'text_color'  => '000000',
                'slug'        => 'editor',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 4,
                'name'        => 'Author',
                'description' => 'Authors can create, edit, and publish their own posts. They can also upload media files to their posts. However, they do not have access to posts created by other users, nor can they manage plugins, themes, or settings.',
                'bg_color'    => 'FFC107',
                'text_color'  => '000000',
                'slug'        => 'author',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 5,
                'name'        => 'Contributor',
                'description' => 'Contributors can write and edit their own posts but cannot publish them. Instead, their posts must be submitted for review and approval by an editor or administrator. Contributors cannot edit or publish posts by other users, and they have limited access to the blog\'s settings.',
                'bg_color'    => '800080',
                'text_color'  => 'FFFFFF',
                'slug'        => 'contributor',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 6,
                'name'        => 'Subscriber',
                'description' => 'Subscribers have the lowest level of access. They can log in to the blog and manage their own user profiles. Subscribers are typically used for readers who want to receive updates or have access to restricted content.',
                'bg_color'    => 'DC3545',
                'text_color'  => '000000',
                'slug'        => 'subscriber',
                'is_active'   => true,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 7,
                'name'        => 'Accountant',
                'description' => 'Accountant is the user role for your accounting or bookkeeping staff. They will have the ability to enter journal entries, closing dates and password, access to the chart of accounts and all accountant/taxes and company financial reporting.',
                'bg_color'    => '28A745',
                'text_color'  => '000000',
                'slug'        => 'accountant',
                'is_active'   => false,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 8,
                'name'        => 'Sales',
                'description' => 'Sales is a role designed for the staff member that needs access to sales orders, sales receipts, sales reports, estimates, and all information in the customer list.',
                'bg_color'    => 'FFC107',
                'text_color'  => '000000',
                'slug'        => 'sales',
                'is_active'   => false,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'id'          => 9,
                'name'        => 'Client',
                'description' => 'Assigned to new customers when they create an account on your website. This role is basically equivalent to that of a normal blog subscriber, but customers can edit their own account information and view past or current orders.',
                'bg_color'    => 'DC3545',
                'text_color'  => '000000',
                'slug'        => 'client',
                'is_active'   => false,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ];
        Role::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
