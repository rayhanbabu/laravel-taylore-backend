<?php

namespace App\Http\Controllers;

use App\Models\Backdetail;
use App\Models\Buttom;
use App\Models\Buttomcut;
use Exception;
use App\Models\Sleeve;
use App\Models\Dept;
use App\Models\Collor;
use App\Models\Pocket;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackendApiController extends Controller
{


    public function department_view(Request $request ,$dept_id){
         $data= Dept::where('id',$dept_id)->first();
         return response()->json([
              'status'=>'success',
              'data'=>$data 
          ],200);
      }

      public function sleeve_view(Request $request ,$dept_id){
        $data= Sleeve::where('dept_id',$dept_id)->get();
        return response()->json([
             'status'=>'success',
             'data'=>$data 
         ],200);
     }


     public function collor_view(Request $request ,$dept_id){
        $data= Collor::where('dept_id',$dept_id)->get();
        return response()->json([
             'status'=>'success',
             'data'=>$data 
         ],200);
     }

     public function pocket_view(Request $request ,$dept_id){
        $data= Pocket::where('dept_id',$dept_id)->get();
          return response()->json([
             'status'=>'success',
              'data'=>$data 
          ],200);
      }

      public function back_detail_view(Request $request ,$dept_id){
        $data= Backdetail::where('dept_id',$dept_id)->get();
          return response()->json([
             'status'=>'success',
              'data'=>$data 
          ],200);
      }

      public function buttom_view(Request $request ,$dept_id){
        $data= Buttom::where('dept_id',$dept_id)->get();
          return response()->json([
             'status'=>'success',
              'data'=>$data 
          ],200);
      }

      public function buttomcut_view(Request $request ,$dept_id){
        $data= Buttomcut::where('dept_id',$dept_id)->get();
          return response()->json([
             'status'=>'success',
              'data'=>$data 
          ],200);
       }


     public function slider_view(Request $request ,$dept_id){
         $data= Slider::where('dept_id',$dept_id)->get();
             return response()->json([
                'status'=>'success',
                'data'=>$data 
             ],200);
        }

}