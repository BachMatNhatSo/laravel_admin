<?php

namespace App\Http\Controllers;

use App\Imports\BookImport;
use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
   public function index(){
        return view('home');
   }
   public function getAllBooks(){
      return view('sach');
   }
  
   public function getAllBooksjson(){
      $book =BookModel::all();
      return response()->json($book,200);
   }
   //api lấy tất cả danh sách sách hiện có 
   public function getAllBooksjson_api(){
      $book =BookModel::all();
      return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);
   }
public function insert(Request $request){
   $validationData= $request ->validate([
      'tensach'=>'required',
      'tacgia'=>'required',
      'giatien'=>'required| integer',
      'nhaxuatban'=>'required'
   ]);
   BookModel::create($validationData);
   // dd($item);
}
public function insert_api(Request $request){
   $validationData= $request ->validate([
      'tensach'=>'required',
      'tacgia'=>'required',
      'giatien'=>'required| integer',
      'nhaxuatban'=>'required'
   ]);
   $item=BookModel::create($validationData);
   return response()->json(['success'=>true,'data'=>$item,'message'=>'thành công']);
}
public function update(Request $request,$id){
   $item =$request ->only(['tensach','tacgia','giatien','nhaxuatban']);
   $book=BookModel::find($id);
   $book->update($item);
   // BookModel::where('id',$id)->update($item);
}
//api cập nhật sách
public function update_api(Request $request,$id){
   $item =$request ->only(['tensach','tacgia','giatien','nhaxuatban']);
   $book=BookModel::find($id);
   $book->update($item);
   return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);
}
public function delete($id){
   $book=BookModel::find($id);
   $book->delete();
   
}
//api xóa 1 quyền sách
public function delete_api($id){
   $book=BookModel::find($id);
   $book->delete();
   return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);
   
}
public function import(Request $request){
   $request->validate(['file'=>'required|mimes:xlsx,xls']);
   $file=$request->file('file');
   Excel::import(new BookImport,$file);
   return redirect()->back()->with('success', 'Data imported successfully.'); 
}
   
}