<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationType;
use Carbon\Carbon;

class ConfigurationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationType::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_types.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationType::create([
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'is_active' => (bool)$data['2'],
                    'created_at' => Carbon::parse($data[3]),
                    'updated_at' => Carbon::parse($data[4]),
                    'configuration_resource_id' => (int)$data['5'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
