<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentFrequency;
use App\Models\LoanType;
use App\Models\LoanOption;

class LoanOptionController extends Controller{

    public function index(){
        $interest=$loan_option->interest;
        $payment_frequencies=PaymentFrequency::all();
        $loan_types=LoanType::all();
        return view('loan_option.index',compact('interest','payment_frequencies','loan_types'));
    }

    public function loan_calcule(Request $request){
        $loan_option=new LoanOption();
        $loan_option->fill($request->all());
        $payment_frequencies=PaymentFrequency::all();
        $loan_types=LoanType::all();
        $table=$loan_option->calculateTable();
        $interest=$loan_option->interest;
        return view('loan_option.index',compact('loan_option','interest','payment_frequencies','loan_types','table'));
    }
    
}
