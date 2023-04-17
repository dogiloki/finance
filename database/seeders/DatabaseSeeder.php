<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LoanType;
use Database\Seeders\PaymentFrequency;
use Database\Seeders\Business;
use Database\Seeders\Contract;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{

        $this->call([
            LoanType::class,
            PaymentFrequency::class,
            Business::class,
            Contract::class,
        ]);

    }
}
