<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationResource;
use Carbon\Carbon;

class ConfigurationResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationResource::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_resources.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationResource::create([
                    'id' => $data['0'],
                    'resource' => $data['1'],
                    'key' => $data['2'],
                    'created_at' => Carbon::parse($data[3]),
                    'updated_at' => Carbon::parse($data[4]),
                    'user_id' => (int)$data['5'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
