<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_UserModel extends Model
{
    use HasFactory;
    protected $table = "book_user";
    protected $primaryKey="id";
    protected $fillable=["id_sach","id_sinhvien","ngaymuon","ngaytra","tinhtrang"];
    public $timestamps = false;
    
}