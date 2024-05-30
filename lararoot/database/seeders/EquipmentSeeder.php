<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipments')->insert([
            [
                'equipment_type_id' => 1,
                'serial_number' => 'AAAA-1111',
                'desc' => 'Description for Type A equipment 1',
            ],
            [
                'equipment_type_id' => 1,
                'serial_number' => 'AAAA-1112',
                'desc' => 'Description for Type A equipment 2',
            ],
            [
                'equipment_type_id' => 2,
                'serial_number' => 'BBBB-2221',
                'desc' => 'Description for Type B equipment 1',
            ],
            [
                'equipment_type_id' => 3,
                'serial_number' => 'CCCC-3331',
                'desc' => 'Description for Type C equipment 1',
            ],
        ]);
    }
}
