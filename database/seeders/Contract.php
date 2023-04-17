<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Contract extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        
        DB::table('contract')->insert([
            ['id'=>1,'name'=>'Simple'],
            ['id'=>2,'name'=>'Cuenta corriente']
        ]);

    }
}
