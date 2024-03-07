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
    // api lấy tất cả phiếu mượn : tinh
    public function getAll_api(){
        $jointable = DB::table('book_user')->select('book_user.id','user.tensinhvien','book.tensach','book_user.tinhtrang','book_user.ngaymuon','book_user.ngaytra')->join('book','book_user.id_sach','=',"book.id")->join('user','user.id','=','book_user.id_sinhvien')->get();
        return response()->json(['success'=>true,'data'=>$jointable,'message'=>'thành công']);
    }
    public function searchTDFT(Request $request){
        $to_date=$request->only('todate');
        $from_date=$request->only('from_date');
        $jointable = DB::table('book_user')->select('book_user.id','user.tensinhvien','book.tensach','book_user.tinhtrang','book_user.ngaymuon','book_user.ngaytra')->join('book','book_user.id_sach','=',"book.id")->join('user','user.id','=','book_user.id_sinhvien');
        if($to_date && $from_date){
            $jointable->WhereBetween('book_user.ngaymuon',[$to_date,$from_date]);
        }
        $jointableData=$jointable->get();
        return response()->json($jointableData);
    }
    //dùng để hiển thị db của 2 ddl
    public function dropdowlist(Request $request){
    
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
        $item = $request->only(['id_sinhvien','id_sach','ngaymuon','ngaytra','tinhtrang']);
            Book_UserModel::create($item);
    }
    public function insert_api(Request $request){
        $item = $request->only(['id_sinhvien','id_sach','ngaymuon','ngaytra','tinhtrang']);
            $book=Book_UserModel::create($item);
            return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);
    }
    public function delete($id){
        $book=Book_UserModel::find($id);
        $book->delete();
        if(!$book){
            response()->json(['errror'=>'loi',404]);
        }
      }
      public function update(Request $request,$id){
        $item= $request->only('id_sinhvien','id_sach','ngaymuon','ngaytra','tinhtrang');
        $muontra=Book_UserModel::find($id);
        $muontra->update($item);
      }
      public function update_api(Request $request,$id){
        $item= $request->only('id_sinhvien','id_sach','ngaymuon','ngaytra','tinhtrang');
        $muontra=Book_UserModel::find($id);
        $muontra->update($item);
        return response()->json(['success'=>true,'data'=>$muontra,'message'=>'thành công']);
      }public function delete_api($id){
        $book=Book_UserModel::find($id);
        $book->delete();
        if(!$book){
            response()->json(['errror'=>'loi',404]);
        }return response()->json(['success'=>true,'data'=>$book,'message'=>'thành công']);

      }

}