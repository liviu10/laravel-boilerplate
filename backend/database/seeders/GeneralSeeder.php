<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\General;
use Carbon\Carbon;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        General::truncate();
        $csvFile = fopen(base_path('database/csv/generals.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                General::create([
                    'id' => $data['0'],
                    'instance_model' => $data['1'],
                    'path' => $data['2'],
                    'instance_field' => $data['3'],
                    'value' => $data['4'],
                    'label' => $data['5'],
                    'created_at' => Carbon::parse($data[6]),
                    'updated_at' => Carbon::parse($data[7]),
                    'user_id' => (int)$data['8'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
