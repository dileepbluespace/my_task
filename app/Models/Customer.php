<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'tbl_candidates';
    protected $primarykey = 'id';

    protected $fillable = ['id', 'name', 'age', 'salary', 'status'];
}
