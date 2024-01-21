<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ResourceChildren;
use Carbon\Carbon;

class ResourceChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ResourceChildren::truncate();
        $csvFile = fopen(base_path('database/csv/resource_children.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ResourceChildren::create([
                    'id'            => $data['0'],
                    'type'          => $data['1'],
                    'path'          => $data['2'],
                    'name'          => $data['3'],
                    'component'     => $data['4'],
                    'layout'        => $data['5'],
                    'title'         => $data['6'],
                    'caption'       => $data['7'],
                    'icon'          => $data['8'],
                    'is_active'     => $data['9'],
                    'requires_auth' => $data['10'],
                    'resource_id'   => $data['11'],
                    'position'      => $data['12'],
                    'created_at'    => $data['13'],
                    'updated_at'    => $data['14'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
