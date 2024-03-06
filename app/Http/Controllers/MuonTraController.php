<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_UserModel;
use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;

class MuonTraController extends Controller
{
    public function index(){
        return view('muontra');
    }
    public function getAll(){
        $jointable = DB::table('book_user')->select('book_user.id','user.tensinhvien','book.tensach','book_user.tinhtrang','book_user.ngaymuon','book_user.ngaytra')->join('book','book_user.id_sach','=',"book.id")->join('user','user.id','=','book_user.id_sinhvien')->get();
        return response()->json($jointable);
    }
    //dùng để hiển thị db của 2 ddl
    public function dropdowlist(Request $request){
    //     $jointable = DB::table('book_user')
    //     ->select('book_user.id', 'user.tensinhvien', 'book.tensach')
    //     ->join('book', 'book_user.id_sach', '=', 'book.id')
    //     ->join('user', 'user.id', '=', 'book_user.id_sinhvien')
    //     ->get();
    //     $dropDownDataSV = [];
    //     $dropDownDataSach = [];

    // foreach($jointable as $item){
    //     $dropDownDataSV[$item->id] = $item->tensinhvien;
    //     $dropDownDataSach[$item->id] = $item->tensach;
    // }

    //     return response()->json(['dropDownDataSV'=>$dropDownDataSV,'dropDownDataSach'=>$dropDownDataSach]);
        $tblBook =BookModel::all();
        $tblSV =UserModel::all();
        $dropDownDataSach = [];
        $dropDownDataSV = [];
        foreach($tblBook as $item){
                $dropDownDataSach[$item->id] = $item->tensach;
            }
        foreach($tblSV as $item){
            $dropDownDataSV[$item->id] = $item->tensinhvien;
        }
            return response()->json(['dropDownDataSach'=>$dropDownDataSach,'dropDownDataSV'=>$dropDownDataSV]);
    }
    public function insert(Request $request){
        $item = $request->only(['id_sinhvien','id_sach','ngaymuon','ngaytra']);
            Book_UserModel::create($item);
    }
    public function delete($id){
        $book=Book_UserModel::find($id);
        $book->delete();
        if(!$book){
            response()->json(['errror'=>'loi',404]);
        }
        
      }

}