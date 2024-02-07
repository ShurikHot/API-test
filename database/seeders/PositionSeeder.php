<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = ['Security', 'Designer', 'Content manager', 'Lawyer', 'Developer'];
        for ($i = 0; $i < count($positions); $i++) {
            $data['position'] = $positions[$i];
            Position::query()->create($data);
        }
    }
}
