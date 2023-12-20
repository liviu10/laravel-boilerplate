<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationColumn;
use Carbon\Carbon;

class ConfigurationColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationColumn::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_columns.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationColumn::create([
                    'id' => $data['0'],
                    'align' => $data['1'],
                    'field' => $data['2'],
                    'header_style' => $data['3'],
                    'label' => $data['4'],
                    'name' => $data['5'],
                    'position' => $data['6'],
                    'style' => $data['7'],
                    'created_at' => Carbon::parse($data[8]),
                    'updated_at' => Carbon::parse($data[9]),
                    'configuration_resource_id' => (int)$data['10'],
                    'configuration_type_id' => (int)$data['11'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
