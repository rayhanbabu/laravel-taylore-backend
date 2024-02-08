<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Pocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PocketController extends Controller
{
   
    public function pocket_view(Request $request){
         try{  
               return view('admin.pocket');
           }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
      }
 
      public function store(Request $request){

       $dept_id = $request->header('dept_id');
       $teacher_id = $request->header('id');
       $validator=\Validator::make($request->all(),[    
          'pocket_name'=>'required',
          'pocket_name'=>'required|unique:pockets,pocket_name',
          'image'=>'image|mimes:jpeg,png,jpg|max:400',
        ],
        );
 
      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
      }else{
             $model= new Pocket;
             $model->dept_id=$dept_id;
             $model->pocket_name=$request->input('pocket_name');
             $model->pocket_des=$request->input('pocket_des');
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
 
    public function pocket_edit(Request $request) {
      $id = $request->id;
      $data = Pocket::find($id);
      return response()->json([
          'status'=>200,  
          'data'=>$data,
       ]);
    }
 
 
    public function pocket_update(Request $request ){

       $validator=\Validator::make($request->all(),[    
         'pocket_name'=>'required',
         'pocket_name'=>'required|unique:pockets,pocket_name,'.$request->input('edit_id'),
         'image'=>'image|mimes:jpeg,png,jpg|max:400',
      ]);
 
     $teacher_id = $request->header('id');
   if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
   }else{
         $model=Pocket::find($request->input('edit_id'));
     if($model){
         $model->pocket_name=$request->input('pocket_name');
         $model->pocket_des=$request->input('pocket_des');
         $model->pocket_status=$request->input('pocket_status');
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
 
 
   public function pocket_delete(Request $request) { 
 
       // $hallinfo=Building::where('id',$request->input('id'))->count('id');
       //  if($hallinfo>0){
       //     return response()->json([
       //       'status'=>200,  
       //       'message'=>'Can not delete this record. This hall is used in hall info table.',
       //      ]);
       //   }else{
           $model=Pocket::find($request->input('id'));
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
       $data=Pocket::where('dept_id',$dept_id)->orderBy('id','desc')->paginate(10);
       return view('admin.pocket_data',compact('data'));
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
             $data = Pocket::where('dept_id',$dept_id)
              ->where(function($query) use ($search) {
                  $query->where('pocket_name', 'like', '%'.$search.'%')
                     ->orWhere('pocket_des', 'like', '%'.$search.'%')
                     ->orWhere('pocket_status', 'like', '%'.$search.'%');
               })->paginate(10);
                   return view('admin.pocket_data', compact('data'))->render();
                  
       }
   }




}
