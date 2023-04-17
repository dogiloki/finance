<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentFrequency;
use App\Models\LoanType;
use App\Models\LoanOption;
use App\Models\Table\ModelTable;

class LoanOptionController extends Controller{

    public function loan(){
        return $this->loadViewForm(LoanType::typeLoan());
    }

    public function credit(){
        return $this->loadViewForm(LoanType::typeCredit());
    }

    public function loadViewForm($loan_types){
        $payment_frequencies=PaymentFrequency::all();
        return view('loan_option.index',compact('payment_frequencies','loan_types'));
    }

    public function loan_calcule(Request $request){
        $loan_option=new LoanOption();
        $loan_option->interest=24;
        $loan_option->interest_vat=16;
        $loan_option->commission=0.05;
        $loan_option->fill($request->all());
        $table=$loan_option->calculateLoan();
        return $this->loadViewTable($loan_option,$table);
    }

    public function credit_calcule(Request $request){
        $loan_option=new LoanOption();
        $loan_option->interest=12;
        $loan_option->interest_vat=16;
        $loan_option->commission=01;
        $loan_option->fill($request->all());
        $table=$loan_option->calculateCredit();
        return $this->loadViewTable($loan_option,$table);
    }

    private function loadViewTable(LoanOption $loan_option, ModelTable $table){
        $payment_frequencies=PaymentFrequency::all();
        $loan_types=LoanType::typeLoan();
        return view('loan_option.index',compact('loan_option','payment_frequencies','loan_types','table'));
    }
    
}
