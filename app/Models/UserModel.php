<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table="user"; 
    protected $primaryKey="id";
    protected $fillable=["tensinhvien","mssv","dienthoai","diachi"];
    public $timestamps = false;
}