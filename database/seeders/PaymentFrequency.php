<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentFrequency extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        
        DB::table('payment_frequency')->insert([
            ['id'=>1,'name'=>'Semanal'],
            ['id'=>2,'name'=>'Quincenal'],
            ['id'=>3,'name'=>'Mensual'],
            ['id'=>4,'name'=>'Bimestral'],
            ['id'=>5,'name'=>'Trimestral'],
            ['id'=>6,'name'=>'Semestral'],
            ['id'=>7,'name'=>'Anual'],
        ]);

    }
}
