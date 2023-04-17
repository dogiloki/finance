<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFillable;
use App\Models\LoanType;
use App\Models\PaymentFrequency;
use App\Models\Table\Business;
use App\Models\Table\Contract;
use App\Models\Table\ModelTable;

class LoanOption extends Model{
    use HasFactory, AutoFillable;

    protected $table='loan_option';

    public function interestRate(): float{
        return $this->interest/100;
    }

    public function interestRateVat(): float{
        return $this->interest_vat/100;
    }

    public function commissionRate(): float{
        return $this->commission/100;
    }

    public function paymentFrequency(){
        return $this->belongsTo(PaymentFrequency::class,'id_payment_frequency');
    }

    public function loanType(){
        return $this->belongsTo(LoanType::class,'id_loan_type');
    }

    public function business(){
        return $this->belongsTo(Business::class,'id_business');
    }

    public function contract(){
        return $this->belongsTo(Contract::class,'id_contract');
    }

    public function calculateLoan(): ModelTable{
        $table=new ModelTable();
        $table->addColumn('Periodo','period');
        $table->addColumn('Fecha de pago','date');
        $table->addColumn('Saldo insoluto','balance');
        $table->addColumn('Comisión','commission');
        $table->addColumn('Amortización','amortization');
        $table->addColumn('Intereses','interest');
        $table->addColumn('IVA','vat');
        $table->addColumn('Pago total','total_payment');
        $interest_rate=$this->interestRate();
        $interest_rate_vat=$this->interestRateVat();
        $commission_rate=$this->commissionRate();
        for($index=0; $index<=$this->term; $index++){
            $row_prev=$table->getRow($index-1);
            $row=[];
            $row['period']=$index;
            $row['date']=$index==0?$this->transaction_at:date('Y-m-'.$this->day_maturity,strtotime($this->transaction_at.' +'.$index.' month'));
            $row['commission']=$index==0?$this->amount*$commission_rate:0;
            if($this->id_loan_type==LoanType::MATURY){
                $row['amortization']=$index==0?0:($row['period']==$this->term?$row_prev['balance']:0);
            }else{
                $row['amortization']=$index==0?0:$this->amount/$this->term;
            }
            $row['balance']=$index==0?$this->amount:$row_prev['balance']-($row['amortization']);
            $date1=new \DateTime($row_prev['date']??null);
            $date2=new \DateTime($row['date']??null);
            $intervale_payment=$date1->diff($date2);
            $row['interest']=$index==0?0:$row_prev['balance']*($interest_rate/360)*$intervale_payment->days;
            $row['vat']=$index==0?$row['commission']*$interest_rate_vat:$row['interest']*$interest_rate_vat;
            $row['total_payment']=$row['commission']+$row['amortization']+$row['interest']+($index==0?$row['vat']:0);

            // Establecer formato de filas
            $row_format['balance']="$ ".number_format($row['balance'],2);
            $row_format['commission']="$ ".number_format($row['commission'],2);
            $row_format['amortization']="$ ".number_format($row['amortization'],2);
            $row_format['interest']="$ ".number_format($row['interest'],2);
            $row_format['vat']="$ ".number_format($row['vat'],2);
            $row_format['total_payment']="$ ".number_format($row['total_payment'],2);

            $table->addRow($row,$row_format);
        }
        return $table;
    }

    public function calculateCredit(): ModelTable{
        $table=new ModelTable();
        $table->addColumn('Periodo','period');
        $table->addColumn('Fecha de inicio','date_index');
        $table->addColumn('Fecha de fin','date_end');
        $table->addColumn('Días','days');
        $table->addColumn('Disposición','disposition');
        $table->addColumn('Saldo insoluto','balance');
        $table->addColumn('Comisión','commission');
        $table->addColumn('Amortización','amortization');
        $table->addColumn('Intereses','interest');
        $table->addColumn('Moratarios','delinquent');
        $table->addColumn('IVA','vat');
        $table->addColumn('Flujo','total_payment');
        $interest_rate=$this->interestRate();
        $interest_rate_vat=$this->interestRateVat();
        $commission_rate=$this->commissionRate();
        $payment=LoanOption::pmt($interest_rate/12,$this->term,$this->amount);
        for($index=0; $index<=$this->term; $index++){
            $row_prev=$table->getRow($index-1);
            $row=[];
            $row['period']=$index;
            $row['date_index']=$index<=1?$this->transaction_at:date('Y-m-'.$this->day_maturity,strtotime($this->transaction_at.' +'.($index-1).' month'));
            $row['date_end']=$index==0?null:date('Y-m-'.$this->day_maturity,strtotime($row['date_index'].' +1 month'));
            $date1=new \DateTime($row['date_index']??null);
            $date2=new \DateTime($row['date_end']??null);
            $intervale_payment=$date1->diff($date2);
            $row['days']=$index==0?null:$intervale_payment->days;
            $row['disposition']=$index==0?(-1*$this->amount):0;
            $row['interest']=$index==0?0:$row_prev['balance']*($interest_rate/360)*$row['days'];
            $row['commission']=$index==0?$this->amount*$commission_rate:0;
            $row['delinquent']=0;
            $row['vat']=($row['commission']+$row['interest']+$row['delinquent'])*$interest_rate_vat;
            if($this->id_loan_type==LoanType::EQUAL_PAYMENTS){
                if($index==0){
                    $row['amortization']=0;
                }else
                if($index==1){
                    $row['amortization']=($payment+$row['vat'])-$row['interest']-$row['vat'];
                }else{
                    $row['amortization']=$payment-$row['interest'];
                }
                $row['total_payment']=$index==0?$row['disposition']+$row['commission']+$row['amortization']+$row['interest']+$row['delinquent']+$row['vat']:$payment+$row['vat'];
            }else
            if($this->id_loan_type==LoanType::EQUAL_AMORTIZATIONS){
                $row['amortization']=$index==0?0:$this->amount/$this->term;
                $row['total_payment']=$row['disposition']+$row['commission']+$row['amortization']+$row['interest']+$row['delinquent']+$row['vat'];
            }else
            if($this->id_loan_type==LoanType::CUSTOMIZED){
                $row['amortization']=$index==$this->term?$this->amount:0;
                $row['total_payment']=$row['disposition']+$row['commission']+$row['amortization']+$row['interest']+$row['delinquent']+$row['vat'];
            }
            if($index==0){
                $row['balance']=-1*$row['disposition'];
            }else
            if($index==1){
                $row['balance']=(-1*$row_prev['disposition'])-$row['amortization'];
            }else{
                $row['balance']=$row_prev['balance']-$row['amortization'];
            }

            // Establecer formato de filas
            $row_format['disposition']="$ ".number_format($row['disposition'],2);
            $row_format['balance']="$ ".number_format($row['balance'],2);
            $row_format['commission']="$ ".number_format($row['commission'],2);
            $row_format['amortization']="$ ".number_format($row['amortization'],2);
            $row_format['interest']="$ ".number_format($row['interest'],2);
            $row_format['delinquent']="$ ".number_format($row['delinquent'],2);
            $row_format['vat']="$ ".number_format($row['vat'],2);
            $row_format['total_payment']="$ ".number_format($row['total_payment'],2);

            $table->addRow($row,$row_format);
        }
        return $table;
    }

    // Calcular el pago periódico
    public static function pmt($interest_rate,$nper,$amount){
        $value1=(((1+$interest_rate)**$nper)*$interest_rate);
        $value2=(((1+$interest_rate)**$nper)-1);
        $pmt=$amount*($value1/$value2);
        return $pmt;
    }

}
