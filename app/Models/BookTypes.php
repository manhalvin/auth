<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookTypes extends Model
{
    use HasFactory;
    protected  $table = "book_types";
    protected $guarded = [];
}
