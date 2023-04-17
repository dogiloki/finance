<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Business extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        
        DB::table('business')->insert([
            ['id'=>1,'name'=>'Pyme'],
            ['id'=>2,'name'=>'Grupal'],
            ['id'=>3,'name'=>'Individual'],
            ['id'=>4,'name'=>'Nomina']
        ]);

    }
}
