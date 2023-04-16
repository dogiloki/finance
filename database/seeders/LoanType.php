<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

        DB::table('loan_type')->insert([
            ['id'=>1,'name'=>'Al vencimiento','description'=>'Los interes se pagan durante todo el plazo del prestamo, y el capital se paga al vencimiento.'],
            ['id'=>2,'name'=>'Amortizable','description'=>'Los pagos periódicos incluyen una parte del capital y los interes. Los interes se calculan sobre el saldo del capital pendiente'],
            ['id'=>3,'name'=>'Con gracia','description'=>'Se estable un período incial durante el cual no se hace ningun pago de capital o intereses, después del período de gracia se comienzan los pagos regulares que incluyen interes y capital.']
        ]);

    }
}
