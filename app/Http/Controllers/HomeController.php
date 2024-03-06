<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

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
public function store(Request $request){
   $validationData= $request ->validate([
      'tensach'=>'required',
      'tacgia'=>'required',
      'giatien'=>'required| integer',
      'nhaxuatban'=>'required'
   ]);
   
   BookModel::created($validationData);
   // dd($item);
 
}
public function update(Request $request,$id){
   $item =$request ->only(['tensach','tacgia','giatien','nhaxuatban']);
   $book=BookModel::find($id);
   $book->update($item);
   // BookModel::where('id',$id)->update($item);
}
public function delete($id){
   $book=BookModel::find($id);
   $book->delete();
   
}
   
}