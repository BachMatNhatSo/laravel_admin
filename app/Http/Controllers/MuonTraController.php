<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_UserModel;
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
        $jointable = DB::table('book_user')
        ->select('book_user.id', 'user.tensinhvien', 'book.tensach')
        ->join('book', 'book_user.id_sach', '=', 'book.id')
        ->join('user', 'user.id', '=', 'book_user.id_sinhvien')
        ->distinct()
        ->get();

return response()->json(['jointable' => $jointable]);
        
    }
    public function insert(Request $request){
        $validation= $request->validate([
            'sinhvien'=>'required',
            'sach'=>'required',
        ]);
        // dump($validation);
            Book_UserModel::create($validation);
    }

}