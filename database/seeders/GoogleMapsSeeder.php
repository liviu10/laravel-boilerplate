<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GoogleMaps;
use Carbon\Carbon;

class GoogleMapsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        GoogleMaps::truncate();
        $records = [
            [
                'id' => 1,
                'description' => 'În perioada 01.05. - 10.05.2024 te așteptăm cu drag la Festivalul Murelor din București să încerci fructele noastre delicioase.',
                'address' => 'Bucuresti',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1,
            ],
        ];

        GoogleMaps::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
