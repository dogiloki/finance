<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFillable;

class Business extends Model{
    use HasFactory, AutoFillable;

    protected $table='business';

}
