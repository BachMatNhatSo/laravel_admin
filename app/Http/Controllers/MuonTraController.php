<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Book_UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function insert(Request $request) {
        try {
            // Validate the incoming request data
            $request->validate([
                'id_sinhvien' => 'required',
                'id_sach' => 'required',
                'ngaymuon' => 'required|date',
                'ngaytra' => 'required|date|after:ngaymuon', // ngaytra must be after ngaymuon
                'tinhtrang' => 'required'
            ]);
    
            // Extract the validated data from the request
            $item = $request->only(['id_sinhvien', 'id_sach', 'ngaymuon', 'ngaytra', 'tinhtrang']);
    
            // Create a new Book_UserModel instance with validated data
            Book_UserModel::create($item);
    
            // Return a success response
            return response()->json(['success' => true, 'data' => $item, 'message' => 'Thành công']);
        } catch (ValidationException $e) {
            // If validation fails, return error response with validation errors
            $errors = $e->validator->errors()->all();
            return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            // If any other unexpected exception occurs, return a generic error response
            return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
      }public function delete_api($id) {
        try {
            // Find the book by ID
            $book = Book_UserModel::findOrFail($id);
    
            // Attempt to delete the book
            $book->delete();
    
            // If deletion is successful, return success response
            return response()->json(['success' => true, 'data' => $book, 'message' => 'Thành công']);
        } catch (ModelNotFoundException $e) {
            // If the book is not found, return error response
            return response()->json(['success' => false, 'error' => 'Không tìm thấy dữ liệu'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // If any other unexpected exception occurs, return generic error response
            return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}