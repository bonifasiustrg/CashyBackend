<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'transaction';
    protected $fillable = [
        'nama',
        'nim',
        'tanggal',
        'category_id',
        'image',
        'description',
        'status'
    ];
}
