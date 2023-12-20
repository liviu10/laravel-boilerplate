<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationInput;
use Carbon\Carbon;

class ConfigurationInputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationInput::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_inputs.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationInput::create([
                    'id' => $data['0'],
                    'accept' => $data['1'],
                    'field' => $data['2'],
                    'is_active' => (bool)$data['3'],
                    'is_filter' => (bool)$data['4'],
                    'is_model' => (bool)$data['5'],
                    'key' => $data['6'],
                    'name' => $data['7'],
                    'position' => $data['8'],
                    'type' => $data['9'],
                    'created_at' => Carbon::parse($data[10]),
                    'updated_at' => Carbon::parse($data[11]),
                    'configuration_resource_id' => (int)$data['12'],
                    'configuration_type_id' => (int)$data['13'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
