<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Backdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackdetailController extends Controller
{
   
    public function backdetail_view(Request $request){
         try{  
               return view('admin.backdetail');
           }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
      }
 
      public function store(Request $request){

       $dept_id = $request->header('dept_id');
       $teacher_id = $request->header('id');
       $validator=\Validator::make($request->all(),[    
          'back_name'=>'required',
          'back_name'=>'required|unique:backdetails,back_name',
          'image'=>'image|mimes:jpeg,png,jpg|max:400',
        ],
        );
 
      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
      }else{
             $model= new backdetail;
             $model->dept_id=$dept_id;
             $model->back_name=$request->input('back_name');
             $model->back_des=$request->input('back_des');
             $model->created_by=$teacher_id;
             if ($request->hasfile('image')) {
               $imgfile = 'booking-';
               $size = $request->file('image')->getsize();
               $file = $_FILES['image']['tmp_name'];
               $hw = getimagesize($file);
               $w = $hw[0];
               $h = $hw[1];
               if ($w < 310 && $h < 310) {
                   $image = $request->file('image');
                   $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                   $image->move(public_path('uploads'), $new_name);
                   $model->image = $new_name;
                } else {
                   return response()->json([
                       'status' => 300,
                       'message' => 'Image size must be 300*300px',
                   ]);
                 }
             }
            
             $model->save();
 
             return response()->json([
                   'status'=>200,  
                   'message'=>'Data Added Successfull',
              ]);     
         }
     }
 
    public function backdetail_edit(Request $request) {
      $id = $request->id;
      $data = Backdetail::find($id);
      return response()->json([
          'status'=>200,  
          'data'=>$data,
       ]);
    }
 
 
    public function backdetail_update(Request $request ){

       $validator=\Validator::make($request->all(),[    
         'back_name'=>'required',
         'back_name'=>'required|unique:backdetails,back_name,'.$request->input('edit_id'),
         'image'=>'image|mimes:jpeg,png,jpg|max:400',
      ]);
 
     $teacher_id = $request->header('id');
   if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
   }else{
         $model=Backdetail::find($request->input('edit_id'));
     if($model){
         $model->back_name=$request->input('back_name');
         $model->back_des=$request->input('back_des');
         $model->back_status=$request->input('back_status');
         $model->updated_by=$teacher_id;

         if ($request->hasfile('image')) {
            $imgfile = 'booking-';
            $size = $request->file('image')->getsize();
            $file = $_FILES['image']['tmp_name'];
            $hw = getimagesize($file);
            $w = $hw[0];
            $h = $hw[1];
            if ($w < 310 && $h < 310) {
              $path = public_path('uploads') . '/' . $model->image;
               if(File::exists($path)){
                   File::delete($path);
                 }
                $image = $request->file('image');
                $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $new_name);
                $model->image = $new_name;
            } else {
               return response()->json([
                   'status' =>300,
                   'message' =>'Image size must be 300*300px',
               ]);
             }
         }
        
          $model->update();   
           return response()->json([ 
              'status'=>200,
              'message'=>'Data Updated Successfull'
           ]);
       }else {
         return response()->json([
             'status'=>404,  
             'message'=>'Student not found',
           ]);
         }
 
     }
   }
 
 
   public function backdetail_delete(Request $request) { 
 
       // $hallinfo=Building::where('id',$request->input('id'))->count('id');
       //  if($hallinfo>0){
       //     return response()->json([
       //       'status'=>200,  
       //       'message'=>'Can not delete this record. This hall is used in hall info table.',
       //      ]);
       //   }else{
           $model=Backdetail::find($request->input('id'));
           $filePath = public_path('uploads') . '/' . $model->image;
           if(File::exists($filePath)){
                 File::delete($filePath);
            }
           $model->delete();
           return response()->json([
              'status'=>300,  
              'message'=>'Data Deleted Successfully',
         ]);
         
     // }
    } 
   
 
 
   public function fetch(Request $request){
       $dept_id = $request->header('dept_id');
       $data=Backdetail::where('dept_id',$dept_id)->orderBy('id','desc')->paginate(10);
       return view('admin.backdetail_data',compact('data'));
    }
 
 
 
   function fetch_data(Request $request)
   {
      if($request->ajax())
       {
          $dept_id = $request->header('dept_id');
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
             $search = $request->get('search');
             $search = str_replace("","%", $search);
             $data = Backdetail::where('dept_id',$dept_id)
              ->where(function($query) use ($search) {
                  $query->where('back_name', 'like', '%'.$search.'%')
                     ->orWhere('back_des', 'like', '%'.$search.'%')
                     ->orWhere('back_status', 'like', '%'.$search.'%');
               })->paginate(10);
                   return view('admin.back_data', compact('data'))->render();
                  
       }
   }




}
