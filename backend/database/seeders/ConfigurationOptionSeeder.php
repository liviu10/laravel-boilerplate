<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationOption;
use Carbon\Carbon;

class ConfigurationOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationOption::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_options.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationOption::create([
                    'id' => $data['0'],
                    'value' => $data['1'],
                    'label' => $data['2'],
                    'created_at' => Carbon::parse($data[3]),
                    'updated_at' => Carbon::parse($data[4]),
                    'configuration_resource_id' => (int)$data['5'],
                    'configuration_type_id' => (int)$data['6'],
                    'configuration_input_id' => (int)$data['7'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
