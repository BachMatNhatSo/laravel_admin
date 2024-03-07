<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KhachHangController extends Controller
{
    public function get(){
        return view('khachhang');
    }
    public function getAllUser(){
       $user=UserModel::all();
       return response()->json($user,200);
  }
  public function getAllUser_api(){
    $user=UserModel::all();
    return response()->json(['success'=>true,'data'=>$user,'message'=>'thành công']);
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
  public function insert_api(Request $request){
    $validation= $request->validate([
        'tensinhvien'=>'required',
        'mssv'=>'required',
        'dienthoai'=>'required',
        'diachi'=>'required'
    ]);
       $item= UserModel::create($validation);
       return response()->json(['success'=>true,'data'=>$item,'message'=>'thành công']);
  }
  public function update(Request $request,$id){
    $item = $request->only(['tensinhvien','mssv','dienthoai','diachi']);
    $userss=UserModel::find($id);
    $userss->update($item);
  }
  public function update_api(Request $request,$id){
    $item = $request->only(['tensinhvien','mssv','dienthoai','diachi']);
    $userss=UserModel::find($id);
    $userss->update($item);
    return response()->json(['success'=>true,'data'=>$item,'message'=>'thành công']);
  }
  //kẹt khóa ngoại 
  public function delete($id){
    $book=UserModel::find($id);
    $book->delete();
    
  }
    //kẹt khóa ngoại 
  public function delete_api($id){
    $book=UserModel::find($id);
    $item=$book->delete();
    if(!$book){
        response()->json(['errror'=>'loi',404]);
    }
    return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);

  }
  public function importsv(Request $request){
    $request->validate(['file'=>'required|mimes:xlsx,xls']);
    $file=$request->file('file');
    Excel::import(new UserImport,$file);
    return redirect()->back()->with('success', 'Data imported successfully.'); 
 }
}