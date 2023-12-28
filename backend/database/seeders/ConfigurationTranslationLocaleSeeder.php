<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigurationTranslationLocale;
use Carbon\Carbon;

class ConfigurationTranslationLocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ConfigurationTranslationLocale::truncate();
        $csvFile = fopen(base_path('database/csv/configuration_translation_locales.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                ConfigurationTranslationLocale::create([
                    'id' => $data['0'],
                    'code' => $data['1'],
                    'country' => $data['2'],
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
