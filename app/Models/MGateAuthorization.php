<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MGateAuthorization extends Model
{
    use HasFactory;

    protected $table = 'm_gateAuthorization'; 
    protected $primaryKey = 'Path';
    
}
