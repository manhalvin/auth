<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTypes extends Model
{
    use HasFactory;
    protected  $table = "book_types";
    protected $guarded = [];
}
