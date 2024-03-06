<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function get(){
        return view('khachhang');
    }
    public function getAllUser(){
       $user=UserModel::all();
       return response()->json($user,200);
  }
  public function insert(Request $request){
    $validation= $request->validate([
        'tensinhvien'=>'required',
        'mssv'=>'required',
        'dienthoai'=>'required',
        'diachi'=>'required'
    ]);
   
       $item= UserModel::create($validation);
      
  }
  public function update(Request $request,$id){
    $item = $request->only(['tensinhvien','mssv','dienthoai','diachi']);
    $userss=UserModel::find($id);
    $userss->update($item);
  }
  public function delete($id){
    $book=UserModel::find($id);
    $book->delete();
    if(!$book){
        response()->json(['errror'=>'loi',404]);
    }
    
  }
}