<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            ['name' => 'Type A', 'mask' => 'AAAA-1111'],
            ['name' => 'Type B', 'mask' => 'BBBB-2222'],
            ['name' => 'Type C', 'mask' => 'CCCC-3333'],
        ]);
    }
}
