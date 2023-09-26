<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AcceptedDomain;
use Carbon\Carbon;

class AcceptedDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        AcceptedDomain::truncate();
        $csvFile = fopen(base_path('database/csv/accepted_domains.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 0, ",")) !== false)
        {
            if (!$firstLine) {
                AcceptedDomain::create([
                    'id' => $data['0'],
                    'domain' => $data['1'],
                    'type' => $data['2'],
                    'created_at' => Carbon::parse($data[3]),
                    'updated_at' => Carbon::parse($data[4]),
                    'user_id' => (int)$data['5'],
                    'is_active' => (bool)$data['6'],
                ]);
            }
            $firstLine = false;
        }
        fclose($csvFile);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
