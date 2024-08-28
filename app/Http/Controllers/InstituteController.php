<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\Department;
use App\Models\TodoList;
use App\Models\Designation;
use App\Models\OfficialInfo;
use App\Models\FacultyDirectorate;
use App\Models\Employee;
use App\Models\User;
use App\Models\Notification;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InstituteController extends Controller
{    
    public function index()
    {
        $keys = [];
        $keys1 = [0];
        $values = [];
        $values1 = [];
        $department_chart = Department::where('user_id','=',Auth::user()->id)->get(); 
     
        $genders = [];
        foreach($department_chart as $key=>$chart){
            $keys[] = $chart->departmentname;
            $keys1[] = $chart->departmentname;
            $data = DB::table('official_infos')->join('employees','employees.id', '=', 'official_infos.employee_id')->where('employees.deleted_at',null)->where('employees.institution_id','=',Auth::user()->id )->where('department',$chart->id)->max('official_infos.gradelevel');
            
            if($data){
              $values[] = $data;
              $values1[] = $data;
            }else{
              $values[] = 0;
              $values1[] = 0;
            }
            

            $male = DB::table('employees')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
            ->rightjoin('users', 'employees.user_id', '=', 'users.id')
            ->where('official_infos.department','=',$chart->id)
            ->where('employees.institution_id','=',Auth::user()->id )
            ->where('employees.sex','=','male')
            ->where('users.deleted_at',null)   
            ->select('*')
            ->count();


            $female = DB::table('employees')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
            ->rightjoin('users', 'employees.user_id', '=', 'users.id')
            ->where('official_infos.department','=',$chart->id)
            ->where('employees.institution_id','=',Auth::user()->id )
            ->where('employees.sex','=','female')
            ->where('users.deleted_at',null)   
            ->select('*')
            ->count();
            
          
            // echo "<br><pre>";
            // print_r([$male,$female]);
            // echo "</pre>";

            $other = DB::table('employees')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->where('official_infos.department','=',$chart->id)
            ->where('employees.institution_id','=',Auth::user()->id )
            ->where('employees.sex','=','other')
            ->where('users.deleted_at',null)   
            ->select('*')
            ->get()->count();
            
            //echo $chart->departmentname. '--';
            // print_r([$male,$female,$other]);
            // echo "<br>";

            $genders[$chart->departmentname] = ['male'=>$male, 'female'=>$female, 'other'=>$other];
        }
        
        // dd($genders);

        $colors = [];
        for ($i = 1; $i <= count($keys); $i++) {
            $colors[] = "#ffb848";
        }

        $months = [];
        $months1 = [];
        for ($i = 1; $i <= 12; $i++) {
            $months1[] = date("F", strtotime( date( 'Y-m-01' )." $i months")).' '.(date("Y", strtotime( date( 'Y-m-01' )." $i months"))-1);
            $months[] = date("F", strtotime( date( 'Y-m-01' )." $i months"));
        }    
        
    
        $monthcountfinal = [];
        foreach($months as $month) {
            $dateObj   = Carbon::createFromFormat('F', $month)->format('m');            
            $monthcount = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')  
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->whereMonth('official_infos.dateofemployment','=',$dateObj )
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();
            $monthcountfinal[] = $monthcount;
        }

        /* Upcoming Birthday start*/        
            $now = Carbon::now();
            $employees = Employee::all();
            $emp_id = [];
            $emp_data = [];
            // find next birthday for each employee
            foreach ($employees as $employee) {                  
                $curyear_bd = Carbon::createFromFormat('Y-m-d H:i:s', $employee->dateofbirth)->setYear($now->year);
                $now > $curyear_bd->endOfDay() ? $next_bd = $curyear_bd->addYear(1) : $next_bd = $curyear_bd;
                if ($now <= $next_bd->startOfDay() && $next_bd <= Carbon::now()->addDay(60)->endOfDay())
                {
                    $emp_id[] = $employee->id;

                    $emps = DB::table('employees')                        
                        ->where('employees.id','=',$employee->id )
                        ->where('employees.institution_id','=',Auth::user()->id )
                        ->select('*')
                        ->get();

                    if($emps->count() > 0){
                        $emp_data[] = $emps;
                    }                    
                }
            }
        /* Upcoming Birthday end*/
        /* Today Birthday start*/
        $today=now();

        $todaybirthday = Employee::whereMonth('dateofbirth',$today->month)  
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')                       
                ->where('employees.institution_id','=',Auth::user()->id )
                ->whereDay('dateofbirth',$today->day)
                ->get();
        /* Today Birthday end*/

        /* Designation V/S Number of Employee start*/
        $designation = [];        
        $designationkey = [];
        $designation_empcount = [];
        $designation_id = [];
        $desigenders = [];
        $designation = Designation::where('user_id','=',Auth::user()->id)
                    ->select('title','designations.id as designation_id')
                    ->get();
                    //dd($designation);
        foreach($designation as $designation => $desichart){
            $designationkey[] = $desichart->title;
            $designation_id[] = $desichart->designation_id;

            $designation_empcount[] = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')  
                ->join('users', 'employees.user_id', '=', 'users.id')
                //->whereMonth('official_infos.dateofemployment','=',$dateObj )
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.designation', '=', $desichart->designation_id )
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $desimale = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.designation','=',$desichart->designation_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('employees.sex','=','male')
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $desifemale = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.designation','=',$desichart->designation_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('employees.sex','=','female')
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $desiother = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.designation','=',$desichart->designation_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('users.deleted_at',null)   
                ->where('employees.sex','=','other')
                ->select('*')
                ->get()->count();

            $desigenders[$desichart->title] = ['male'=>$desimale, 'female'=>$desifemale, 'other'=>$desiother];
        }
        /* Designation V/S Number of Employee end */
        /* Faculty V/S Number of Employee start*/
        $faculty = [];        
        $facultykey = [];
        $faculty_empcount = [];
        $faculty_id = [];
        $facultygenders = [];
        $faculty = FacultyDirectorate::where('user_id','=',Auth::user()->id)
                    ->select('facultyname','faculty_directorates.id as faculty_id')
                    ->get();

        foreach($faculty as $faculty => $facultykeychart){
            $facultykey[] = $facultykeychart->facultyname;
            $faculty_id[] = $facultykeychart->faculty_id;

            $faculty_empcount[] = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')  
                ->join('users', 'employees.user_id', '=', 'users.id')
                //->whereMonth('official_infos.dateofemployment','=',$dateObj )
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.directorate', '=', $facultykeychart->faculty_id )                
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $facultymale = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.directorate','=',$facultykeychart->faculty_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('employees.sex','=','male')
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $facultyfemale = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.directorate','=',$facultykeychart->faculty_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('employees.sex','=','female')
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $facultyother = DB::table('employees')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('official_infos.directorate','=',$facultykeychart->faculty_id)
                ->where('employees.institution_id','=',Auth::user()->id )
                ->where('employees.sex','=','other')
                ->where('users.deleted_at',null)   
                ->select('*')
                ->get()->count();

            $facultygenders[$facultykeychart->title] = ['male'=>$facultymale, 'female'=>$facultyfemale, 'other'=>$facultyother];
        }
        /* Faculty V/S Number of Employee end */

        /*todolistview start*/
        $todoviewpending = TodoList::where('user_id','=',Auth::user()->id)
                    ->where('completed_status','P')
                    ->get();
        /*$todoviewcompleted = TodoList::where('user_id','=',Auth::user()->id)
                    ->where('completed_status','C')
                    ->get();*/

        /*todolistview end*/
  
        // $notifications = Notification::where('visible_users','=',Auth::user()->id)->where('is_read','=',0)->limit(5)->get();
        return view('institute/home',compact('colors','keys', 'values', 'keys1', 'values1','genders', 'months', 'months1', 'monthcountfinal', 'emp_data', 'todaybirthday', 'designationkey', 'designation_empcount', 'desigenders', 'facultykey', 'faculty_empcount', 'facultygenders','todoviewpending'/*,'todoviewcompleted'*/));
    }

    public function readAllNotification( Request $request ) {
        // $data = $request->all();
        // dd($data);
        $data = Notification::all();
        foreach($data as $temp)
        if( !empty( $temp['visible_users'] ) ) :
            $notification = Notification::where('visible_users','=',Auth::user()->id )->update( ['is_read' => '1' ] );
    	    $notification = Notification::where('visible_users','=',Auth::user()->id )->get();
        //  dd($notification);
         return view('emp_dashboard/employeehome', compact('notification'));
        endif;
        // $data = $request->all();
        // if( !empty( $data['isIds'] ) ) :
        //     $notifications = Notifications::where( 'id', $data['isIds'] )->update( ['is_read' => '1' ] );
        // endif;
    }
    
    public function saveToDoData(Request $request)
    {
        $todolist = new TodoList();
        $todolist->todo_title = $request['todo_title'];
        $todolist->todo_date = Carbon::createFromFormat('d/m/Y', $request['tododate'])->toDateTimeString();
        $todolist->user_id = Auth()->user()->id;
        $results = $todolist->save();
        if ($results) {
            return redirect()->route('home.institute')->with('success',"Todo Added Successfully.");            
        } else {
            return redirect()->route('home.institute')->with('error',"Error In Adding Todo.");
        }
    }

    public function removetodo(Request $request)
    {
        $to_do = TodoList::find($request->id);
        $to_do->completed_status = "C";
        $to_do->user_id = Auth()->user()->id;
        $to_do->save();
        $html = "";
        return response()->json('html');
    }

    public function getToDoList(Request $request)
    {
        $to_do_list = TodoList::where('completed_status', 'C')->where('user_id', Auth::user()->id)->get();
        $datas = [];
        foreach ($to_do_list as $to_do) {
            $datas[] = array(
                'title' => $to_do->todo_title,
                'date' => date('jS M, Y', strtotime($to_do->todo_date))
            );
        }
        return response()->json($datas);
    }

    public function list()
    {
    	$data = User::select('*')
                ->where('is_school', '=', 1)
                ->get();
        return view('institute/list',['data'=> $data]);
    }

    public function profile(){
        
        return view('institute.profile');
    }

    public function updateprofile(Request $request){
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
    
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $request->image->move('public/images/', $filename);
            Auth()->user()->update(['image'=>$filename]);
        }
        // else{
        //     return back()->with('erorr','Profile Not Updated');
        // }

        $user = Auth::user();
        $user->email = $request['email'];
        $user->contact_no = $request['contact_no'];
        $user->mobile = $request['moblie'];
        $user->address = $request['address'];  
        $user->save();
       
        return back()->with('success','Profile Updated Successfully');
    }

}
