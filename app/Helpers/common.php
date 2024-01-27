<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use App\Helpers\MaintainJWTToken;
    use App\Helpers\TeacherJWTToken;
    use App\Models\Teacher;
    use Illuminate\Support\Facades\Cookie;
    use App\Models\Week;

       function prx($arr){
           echo "<pre>";
           print_r($arr);
           die();
       }

       function rayhan(){
          return 'Md Rayhan Babu';
       }

       function admin_name($admin_id){
           $admin=DB::table('admins')->where('id',$admin_id)->first();
           return $admin->name;
        }


        function baseimage($path){
            //$path = 'image/slide1.jpg';
             $type = pathinfo($path, PATHINFO_EXTENSION);
             $data = file_get_contents($path);
           return  $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
       }

       function SendEmail($email,$subject,$body,$otp,$name){
           $details = [
             'subject' => $subject,
             'otp_code' =>$otp,
             'body' => $body,
             'name' => $name,
           ];
          Mail::to($email)->send(new \App\Mail\LoginMail($details));
       }


        function maintainaccess(){
            $token_maintain=Cookie::get('token_maintain');
            $result=MaintainJWTToken::ReadToken($token_maintain);
            if($result=="unauthorized"){
                return redirect('/maintain/login');
            }
            else if($result->role=="supperadmin"){
                return true;
            }else{
                return false;
            }
        }


        
        function teacher_info(){
            $teacher_info=Cookie::get('teacher_info');
            $result=unserialize($teacher_info);
            return $result;
        }


        function adminaccess(){
            $token_teacher=Cookie::get('token_teacher');
            $result=TeacherJWTToken::ReadToken($token_teacher);
            if($result=="unauthorized"){
                return redirect('/teacher/login');
            }
            else if($result->role=="admin"){
                return true;
            }else{
                return false;
            }
        }

  function programe_category(){
          $token_teacher=Cookie::get('token_teacher');
          $result=TeacherJWTToken::ReadToken($token_teacher);
          $category=DB::table('programes')->where('dept_id',$result->dept_id)->get();
          return $category;
   }

   function exam_category(){
    $token_teacher=Cookie::get('token_teacher');
    $result=TeacherJWTToken::ReadToken($token_teacher);
    $examiner=DB::table('examiners')->where('dept_id',$result->dept_id)->get();
    return $examiner;
}







function week_details($week_id){      
     $data=Week::where('id',$week_id)->where('category_name','Week')->first();
      return $data;
}




 
?>

      
        
