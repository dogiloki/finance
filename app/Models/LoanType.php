<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFillable;

class LoanType extends Model{
    use HasFactory, AutoFillable;

    protected $table='loan_type';

    // Tipos de prestamos y créditos
    public const MATURY=1;
    public const AMORTIZABLE=2;
    public const GRACE_PERIOD=3;
    public const EQUAL_PAYMENTS=4;
    public const EQUAL_AMORTIZATIONS=5;
    public const CUSTOMIZED=6;

}
