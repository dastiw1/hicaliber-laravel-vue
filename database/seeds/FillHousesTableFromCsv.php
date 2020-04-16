<?php

use Illuminate\Database\Seeder;

class FillHousesTableFromCsv extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();


        $handle = fopen(storage_path('csv/property-data.csv'), "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ",")) {

            if ($header) {
                $header = false;
            } else {
                \App\Models\House::create($this->lineToArray($csvLine));
            }
        }


        \DB::commit();
    }

    public function lineToArray($line)
    {
        $range = [
            'name',
            'price',
            'bedrooms',
            'bathrooms',
            'storeys',
            'garages',
        ];
        $arr = [];
        foreach ($range as $key => $value) {
            $arr[$value] = $line[$key];
        }
        return $arr;
    }
}
