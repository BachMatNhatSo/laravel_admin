<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    use HasFactory;
    protected $table="book";
    protected $primaryKey="id";
    protected $fillable=["tensach","tacgia","giatien","nhaxuatban"];
    public $timestamps = false;
}