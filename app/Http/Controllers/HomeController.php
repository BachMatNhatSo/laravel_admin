<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use App\Imports\BookImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
   public function getAllBooksjson_api(Request $request){
     $query = BookModel::query();
     if($request ->filled('sortField')){
      $query->orderBy($request->sortField,$request->input('sortOrder','asc'));
     }
     $pageSize = $request->input('pageSize', 10);
     $books = $query->paginate($pageSize, ['*'], 'page', $request->input('page', 1));

     return response()->json(['success' => true, 'data' => $books, 'message' => 'Thành công'], 200);

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
   
   try{
      $validationData= $request ->validate([
         'tensach'=>'required',
         'tacgia'=>'required',
         'giatien'=>'required| integer|min:0',
         'nhaxuatban'=>'required'
      ]);
      $item=BookModel::create($validationData);
      return response()->json(['success'=>true,'data'=>$item,'message'=>'thành công']);
   }catch (ValidationException $e) {
       
        $errors = $e->validator->errors()->all();
        return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
public function update(Request $request,$id){
   $item =$request ->only(['tensach','tacgia','giatien','nhaxuatban']);
   $book=BookModel::find($id);
   $book->update($item);
   // BookModel::where('id',$id)->update($item);
}
//api cập nhật sách
public function update_api(Request $request, $id) {
   try {
       $request->validate([
           'tensach' => 'required',
           'tacgia' => 'required',
           'giatien' => 'required|numeric|min:0', 
           'nhaxuatban' => 'required'
       ]);
       
       $item = $request->only(['tensach', 'tacgia', 'giatien', 'nhaxuatban']);
       
       $book = BookModel::findOrFail($id);
       $book->update($item);
       
       return response()->json(['success' => true, 'data' => $book, 'message' => 'Thành công']);
   } catch (ValidationException $e) {
       $errors = $e->validator->errors()->all();
       return response()->json(['success' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
   } catch (\Exception $e) {
     
       return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
   }
}
public function delete($id){
   $book=BookModel::find($id);
   $book->delete();
   
}
//api xóa 1 quyền sách
public function delete_api($id) {
   try {
       $book = BookModel::findOrFail($id); 
       $book->delete();
       return response()->json(['success' => true, 'data' => $book, 'message' => 'Thành công']);
   } catch (ModelNotFoundException $e) {
       return response()->json(['success' => false, 'error' => 'Sách không tồn tại'], Response::HTTP_NOT_FOUND);
   } catch (\Exception $e) {
       return response()->json(['success' => false, 'error' => 'Đã xảy ra lỗi không mong muốn'], Response::HTTP_INTERNAL_SERVER_ERROR);
   }
}
public function import(Request $request){
   $request->validate(['file'=>'required|mimes:xlsx,xls']);
   $file=$request->file('file');
   Excel::import(new BookImport,$file);
   return redirect()->back()->with('success', 'Data imported successfully.'); 
}
   
}