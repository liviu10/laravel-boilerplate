<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationMenu;
use Carbon\Carbon;

class ApplicationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ApplicationMenu::truncate();
        $records = [
            [
                'id'            => 1,
                'path'          => '/admin',
                'name'          => 'HomePage',
                'component'     => 'pages/admin/HomePage.vue',
                'layout'        => 'src/layouts/AdminLayout.vue',
                'title'         => 'admin.home.title',
                'caption'       => 'admin.home.caption',
                'icon'          => 'home',
                'is_active'     => true,
                'requires_auth' => true,
                'user_id'       => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ];
        ApplicationMenu::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
