<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\toukei\toukei2Model;

class toukei2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=1;$i<=13;$i++) {
            toukei2Model::create(
                [
                    "no" => $i,
                    "use"=> 0,
                    "win"=> 0,
                    "perwin"=>0
                ]
            );
        }
    }
}
