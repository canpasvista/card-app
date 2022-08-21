<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\toukei\toukei1Model;

class toukei1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=0;$i<1000;$i++) {
            toukei1Model::create(
                [
                    "time" => $i*10,
                    "cnt"=> 0
                ]
            );
        }
    }
}
