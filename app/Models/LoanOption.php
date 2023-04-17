<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFillable;
use App\Models\LoanType;
use App\Models\PaymentFrequency;
use App\Models\Table\ModelTable;

class LoanOption extends Model{
    use HasFactory, AutoFillable;

    public $interest=24;
    public $interest_vat=24;
    public $commission=0.05;

    public function interestRate(): float{
        return $this->interest/100;
    }

    public function interestRateVat(): float{
        return $this->interest_vat/100;
    }

    public function commissionRate(): float{
        return $this->commission/100;
    }

    protected $table='loan_option';

    public function calculateTable(): ModelTable{
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
            if($this->id_loan_type==1){
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
            $table->addRow($row);
        }
        return $table;
    }

}
