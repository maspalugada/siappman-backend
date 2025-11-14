<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;

class ManageableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrumentTypes = [
            ['name' => 'STEAM'],
            ['name' => 'EO'],
            ['name' => 'DTT'],
        ];

        foreach ($instrumentTypes as $type) {
            InstrumentType::create($type);
        }

        $units = [
            ['name' => 'L T 8, SUKAMAN/EBONY'],
            ['name' => 'L T 8, SUKAMAN/SILVER'],
            ['name' => 'L T 7, RAWAT ANAK'],
            ['name' => 'L T 6, IW BEDAH'],
            ['name' => 'L T 6, IW MEDIKAL'],
            ['name' => 'L t 4, ICU DEWASA'],
            ['name' => 'L T 3, ICVCU MERANTI'],
            ['name' => 'L T 3, ICVCU CANOPUS'],
            ['name' => 'L T 3, ICVCU ULIN'],
            ['name' => 'L T 8, ICU ANAK'],
            ['name' => 'L T 6, ICVCU PEDIATRIK'],
            ['name' => 'L T 6, IW ANAK'],
            ['name' => 'L T 5'],
            ['name' => 'L T 4'],
            ['name' => 'L T 3'],
            ['name' => 'U G D'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        $locations = [
            ['name' => 'Gedung VENTRICLE'],
            ['name' => 'Gedung PERAWATAN'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
