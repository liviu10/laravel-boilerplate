<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Permission::truncate();
        $csvFile = fopen(base_path('database/csv/permissions.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                Permission::create([
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'description' => $data['2'],
                    'is_active' => (bool)$data[3],
                    'need_approval' => (bool)$data[4],
                    'reports_to_role_id' => (int)$data[5],
                    'created_at' => Carbon::parse($data[6]),
                    'updated_at' => Carbon::parse($data[7]),
                    'role_id' => (int)$data[8],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
