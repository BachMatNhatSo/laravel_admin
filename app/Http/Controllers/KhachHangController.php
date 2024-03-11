<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KhachHangController extends Controller
{
    public function get(){
        return view('khachhang');
    }
    public function getAllUser(){
       $user=UserModel::all();
       return response()->json($user,200);
  }
  public function getAllUser_api(Request $request){
    $query = UserModel::query();
    if($request ->filled('sortField')){
     $query->orderBy($request->sortField,$request->input('sortOrder','asc'));
    }
    $pageSize = $request->input('pageSize', 10);
    $user = $query->paginate($pageSize, ['*'], 'page', $request->input('page', 1));

    return response()->json(['success'=>true,'data'=>$user,'message'=>'thành công']);
}
public function insert(Request $request) {
  try {
  
      $validation = $request->validate([
          'tensinhvien' => 'required',
          'mssv' => 'required',
          'dienthoai' => 'required|numeric|min:0',
          'diachi' => 'required'
      ]);

      $item = UserModel::create($validation);
      return response()->json(['success' => true, 'data' => $item, 'message' => 'Thành công']);
  } catch (ValidationException $e) {
      $errors = $e->validator->errors()->all();
      return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
  } catch (\Exception $e) {
      return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
  public function insert_api(Request $request){
    try {
        $validation = $request->validate([
            'tensinhvien' => 'required',
            'mssv' => 'required',
            'dienthoai' => 'required|numeric|min:0',
            'diachi' => 'required'
        ]);
        
        $item = UserModel::create($validation);
        
        return response()->json(['success' => true, 'data' => $item, 'message' => 'Thành công']);
    } catch (ValidationException $e) {
        $errors = $e->validator->errors()->all();
        return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
  public function update(Request $request,$id){
    $item = $request->only(['tensinhvien','mssv','dienthoai','diachi']);
    $userss=UserModel::find($id);
    $userss->update($item);
  }
  public function update_api(Request $request, $id) {
    try {
        $request->validate([
            'tensinhvien' => 'required',
            'mssv' => 'required',
            'dienthoai' => 'required|numeric|min:0',
            'diachi' => 'required'
        ]);
        $item = $request->only(['tensinhvien', 'mssv', 'dienthoai', 'diachi']);
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user->update($item);
        return response()->json(['success' => true, 'data' => $item, 'message' => 'Thành công']);
    } catch (ValidationException $e) {
        $errors = $e->validator->errors()->all();
        return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
  //kẹt khóa ngoại 
  public function delete($id){
    $book=UserModel::find($id);
    $book->delete();
    
  }
    //kẹt khóa ngoại 
    public function delete_api($id) {
      try {
          $book = UserModel::findOrFail($id); 
          $book->delete();
          
          return response()->json(['success' => true, 'data' => $book, 'message' => 'Thành công']);
      } catch (ModelNotFoundException $e) {
          return response()->json(['success' => false, 'error' => 'Không tìm thấy dữ liệu'], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
          return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  }
  public function importsv(Request $request){
    $request->validate(['file'=>'required|mimes:xlsx,xls']);
    $file=$request->file('file');
    Excel::import(new UserImport,$file);
    return redirect()->back()->with('success', 'Data imported successfully.'); 
 }
}