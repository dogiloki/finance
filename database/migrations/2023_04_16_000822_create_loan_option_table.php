<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_option', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_loan_type')->unsigned();
            $table->bigInteger('id_payment_frequency')->unsigned();
            $table->decimal('amount',10,2);
            $table->integer('term');
            $table->integer('day_maturity')->nullable();
            $table->decimal('interest_rate',5,2)->default(0);
            $table->date('transaction_at');
            $table->timestamps();
            $table->foreign('id_loan_type')->references('id')->on('loan_type');
            $table->foreign('id_payment_frequency')->references('id')->on('payment_frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_option');
    }
};
