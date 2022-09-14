<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Windo extends Model
{
    use HasFactory;

    protected $table="windowz";

    protected $fillable=['window','exists','enabled','visible','active','maximised','minimised','process','computer_serial','epoch'];
}
