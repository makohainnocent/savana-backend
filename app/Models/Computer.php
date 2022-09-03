<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $table='computers';

    protected $fillable=['id','serial','company_id','cpuArchitecture','osArchitecture','osType','computerName'];
}
