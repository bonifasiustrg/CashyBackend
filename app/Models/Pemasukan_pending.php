<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan_pending extends Model
{
    use HasFactory;
    
    protected $fillable = ['desc', 'created_at', 'nominal', 'status'];
}
