<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MaintainController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UniverController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SleeveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('locale/{locale}',function($locale){
         Session::put('locale',$locale);
         return redirect()->back();
    });


     //Mainatin Panel
     Route::get('/maintain/login',[MaintainController::class,'login'])->middleware('MaintainTokenExist');
     Route::post('maintain/login-insert',[MaintainController::class,'login_insert']);
     Route::post('/maintain/login-verify',[MaintainController::class,'login_verify']);
     Route::get('maintain/forget',[MaintainController::class,'forget']); 
     Route::post('maintain/forget',[MaintainController::class,'forgetemail']); 
     Route::post('maintain/forgetcode',[MaintainController::class,'forgetcode']); 
     Route::post('maintain/confirmpass',[MaintainController::class,'confirmpass']);
   
   
     Route::middleware('MaintainToken')->group(function(){
          Route::get('/maintain/dashboard',[MaintainController::class,'dashboard']);
          Route::get('/maintain/logout',[MaintainController::class,'logout']);

          Route::get('maintain/password',[MaintainController::class,'passwordview']);
          Route::post('maintain/password',[MaintainController::class,'passwordupdate']);

           //Department  create
           Route::get('/maintain/dept_view',[DeptController::class,'dept_view']);
           Route::get('/maintain/dept_fetch',[DeptController::class,'fetch']);
           Route::get('/maintain/dept/fetch_data',[DeptController::class,'fetch_data']);
           Route::post('/maintain/dept_store',[DeptController::class,'store']);
           Route::get('/maintain/dept_edit',[DeptController::class,'dept_edit']);
           Route::post('/maintain/dept_update',[DeptController::class,'dept_update']);
           Route::delete('/maintain/dept_delete',[DeptController::class,'dept_delete']);
      
          Route::middleware('SupperAdminToken')->group(function(){
     
           //maintain people add
           Route::get('maintain/maintainview',[MaintainController::class,'maintainview']);
           Route::post('/maintain/store',[MaintainController::class,'store']);
           Route::get('/maintain/fetchAll',[MaintainController::class,'fetchAll']);
           Route::get('/maintain/edit',[MaintainController::class,'edit']);
           Route::post('/maintain/update',[MaintainController::class,'update']);


                 //Universty route
           Route::get('maintain/univer-view',[UniverController::class,'univer_view']);
           Route::post('/univer/store',[UniverController::class,'store']);
           Route::get('/univer/fetchAll',[UniverController::class,'fetchAll']);
           Route::get('/univer/edit',[UniverController::class,'edit']);
           Route::post('/univer/update',[UniverController::class,'update']);
           Route::delete('/univer/delete',[UniverController::class,'delete']);
           Route::post('/maintain/import',[UniverController::class,'import']);
           Route::post('/maintain/export',[UniverController::class,'export']);
           Route::post('/maintain/dompdf',[UniverController::class,'dompdf']);
           Route::post('/maintain/jsprint',[UniverController::class,'jsprint']);

           Route::post('/maintain/member_import',[MaintainController::class,'member_import']);
           Route::post('/maintain/member_export',[MaintainController::class,'member_export']);

           //Week  route
           Route::get('maintain/week-view',[WeekController::class,'week_view']);
           Route::post('/week/store',[WeekController::class,'store']);
           Route::get('/week/fetchAll',[WeekController::class,'fetchAll']);
           Route::get('/week/edit',[WeekController::class,'edit']);
           Route::post('/week/update',[WeekController::class,'update']);
           Route::delete('/week/delete',[WeekController::class,'delete']);

             });

         });


       //Teacher Panel
       Route::get('/admin/login',[TeacherController::class,'login'])->middleware('TeacherTokenExist');
       Route::post('admin/login-insert',[TeacherController::class,'login_insert']);
       Route::post('/admin/login-verify',[TeacherController::class,'login_verify']);
       Route::get('admin/forget',[TeacherController::class,'forget']); 
       Route::post('admin/forget',[TeacherController::class,'forgetemail']); 
       Route::post('admin/forgetcode',[TeacherController::class,'forgetcode']); 
       Route::post('admin/confirmpass',[TeacherController::class,'confirmpass']);
 
 
      Route::middleware('TeacherToken')->group(function(){
          Route::get('/admin/dashboard',[TeacherController::class,'dashboard']);
          Route::get('/admin/logout',[TeacherController::class,'logout']);
          Route::get('admin/password',[TeacherController::class,'passwordview']);
          Route::post('admin/password',[TeacherController::class,'passwordupdate']); 


          //sleeve  create
          Route::get('/admin/sleeve_view',[SleeveController::class,'sleeve_view']);
          Route::get('/admin/sleeve_fetch',[SleeveController::class,'fetch']);
          Route::get('/admin/sleeve/fetch_data',[SleeveController::class,'fetch_data']);
          Route::post('/admin/sleeve_store',[SleeveController::class,'store']);
          Route::get('/admin/sleeve_edit',[SleeveController::class,'sleeve_edit']);
          Route::post('/admin/sleeve_update',[SleeveController::class,'sleeve_update']);
          Route::delete('/admin/sleeve_delete',[SleeveController::class,'sleeve_delete']);

         
         Route::middleware('AdminToken')->group(function(){

              //Teacher  create
              Route::get('/admin/teacher_view',[TeacherController::class,'teacher_view']);
              Route::get('/admin/teacher_fetch',[TeacherController::class,'fetch']);
              Route::get('/admin/teacher/fetch_data',[TeacherController::class,'fetch_data']);
              Route::post('/admin/teacher_store',[TeacherController::class,'store']);
              Route::get('/admin/teacher_edit',[TeacherController::class,'teacher_edit']);
              Route::post('/admin/teacher_update',[TeacherController::class,'teacher_update']);
              Route::delete('/admin/teacher_delete',[TeacherController::class,'teacher_delete']);
   
          });

          
          
          // Reports pdf
          Route::get('/pdf/semester_routine', [PdfController::class,'semester_routine_pdf']);



      });

     








     Route::get('/', function (){
            return view('welcome');
      });

     Route::get('/send-mail', function () {
          $details = [
              'title' => 'Sample Title From Mail',
              'body' => 'This is sample content we have added for this test mail'
          ];
        Mail::to('rayhanbabu458@gmail.com')->send(new \App\Mail\SendMail($details));
        dd("Email is Sent, please check your inbox.");
   });
