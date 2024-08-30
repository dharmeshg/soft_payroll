<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Redirect;
use App\Models\OfficialInfo;
use App\Models\User;
use App\Models\AcademicQualification;
use App\Models\Kin_detail;
use App\Models\RefereeInfo;
use App\Models\Residential;
use App\Models\SalaryDetails;
use App\Models\Leavetype;
use App\Models\Transfer;
use App\Models\WorkExperience;
use Storage;
use Hash;
use Auth;
//use DB;
use App\Models\Department;
use App\Models\Designation;
use App\Models\FacultyDirectorate;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Nationality;
use App\Mail\ContactMail;
use Mail;
use App\Models\LocalGovernment;
use App\Models\InstitutePermission;
use App\Models\StateOrigin;
use App\Models\Unit;
use App\Models\Certificate;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

//use Codedge\Fpdf\Fpdf\Fpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use DateTime;
use App\Models\NonAcademicsDepartment;
use App\Models\Division;
use App\Models\NonAcademicUnit;
use App\Models\NonAcademicsDesignation;


class EmployeeController extends Controller
{
    public function AssignLeave($id){

        $permission=InstitutePermission::get();
        $data = Employee::find($id);
        // $data = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $leavetype = Leavetype::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('employee.AddLeave',compact('data','leavetype','permission'));
    }

    public function StoreLeave(Request $request,$id){
        $validatedData = $request->validate([
            'leavetype_id' => 'required',
        ]);
        $assignLeave=Employee::find($id);
        $assignLeave->leavetype_id =implode(',', $request['leavetype_id']);
        $assignLeave->save();

        if($assignLeave)
            return redirect()->route('employee.list')->with('success',"Leave Assign Successfully.");
        else
            return redirect()->route('employee.list')->with('error',"Error In Assign Leave.");
    }

    public function StorePermission(Request $request,$id){
        $validatedData = $request->validate([
            'permission_id' => 'required',
        ]);
        $assignPermission=Employee::find($id);
        $assignPermission->permission_id =implode(',', $request['permission_id']);
        $assignPermission->save();

        if($assignPermission)
            return redirect()->route('employee.list')->with('success',"Permission Assign Successfully.");
        else
            return redirect()->route('employee.list')->with('error',"Error In Assign Permission.");
    }

    public function add()
    {
        $data = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $employee = Employee::orderBy('id', 'DESC')->first();
        if (isset($employee) && !empty($employee)) {
            $order_next_id = $employee->id + 1;
        } else {
            $order_next_id = 1;
        }

        $order_next_id = sprintf('%07d', $order_next_id);

        //$departments = new Department;
        //$departments = Department::get();
        $departments = Department::where('user_id','=',Auth::user()->id)->get();
        // dd($departments);   
        
        //$designations = Designation::get();
        $designations = Designation::where('user_id','=',Auth::user()->id)->get();
        $units = Unit::where('user_id','=',Auth::user()->id)->get();
        //$facultydirectorates = FacultyDirectorate::get();
        $facultydirectorates = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $countries = Country::get();
        $nationalities = Nationality::get();
        $localgovermentoforigins = LocalGovernment::get();
        $states = State::get();
        $stateoforigins = StateOrigin::get();

        if(Auth::user()->category == 'Non-Academic' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV')){
            $non_academic_departments = NonAcademicsDepartment::where('id','=',Auth::user()->employee->official_information->non_Academic_department)->get();
            $division = Division::where('user_id','=',Auth::user()->id)->get();
            $non_academic_units = NonAcademicUnit::where('user_id','=',Auth::user()->id)->get();
            $non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();
            $work_non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->employee->institution_id)->get();
            $work_non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->employee->institution_id)->get();


        }else{
            $non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->id)->get();
            $work_non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->id)->get();

            $division = Division::where('user_id','=',Auth::user()->id)->get();
            $non_academic_units = NonAcademicUnit::where('user_id','=',Auth::user()->id)->get();
            $non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();
            $work_non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();

        }




        return view('employee/add1', compact('order_next_id', 'departments', 'designations', 'facultydirectorates', 'countries', 'nationalities', 'localgovermentoforigins', 'states', 'stateoforigins', 'units','data', 'non_academic_departments', 'division', 'non_academic_units', 'non_academic_designations', 'work_non_academic_departments', 'work_non_academic_designations'));
    }

    public function getState(Request $request)
    {
        $data['states'] = DB::table('states')->where("country_id", $request->country_id)
            ->get();
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        $data['cities'] = DB::table('cities')->where("state_id", $request->state_id)
            ->get();
        return response()->json($data);
    }

    public function checkemail(Request $request)
    {
        if(isset($request->email)){
            $user = User::where('email',$request->value)->where('email','!=',$request->email)->first();
            if($user){
                echo json_encode(['status'=>'fail','message'=>'Email Already taken, Please try again.']);
            }else{
                echo json_encode(['status'=>'success','message'=>'']);
            }
        }else{
            $user = User::where('email',$request->value)->first();
            if($user){
                echo json_encode(['status'=>'fail','message'=>'Email Already taken, Please try again.']);
            }else{
                echo json_encode(['status'=>'success','message'=>'']);
            }
        }
    }

    public function localgoverment(Request $request)
    {
        $data['local_governments'] = DB::table('local_governments')->where("state_id", $request->state_id)
            ->get();

        if(count($data['local_governments']) == 0){
            $data['local_governments'] = DB::table('cities')->where("state_id", $request->state_id)
            ->get();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'password'=>'required|min:8'
        ]);

        $Employee = new Employee();
        $Employee->fname = $request['fname'];
        $Employee->mname = $request['mname'];
        $Employee->lname = $request['lname'];
        $Employee->employeeemail = $request['employeeemail'];
        $Employee->password = $request['password'];
        $Employee->sex   = $request['sex'];
        $Employee->otherfield = $request['otherfield'];
        /*$Employee->dateofbirth = $request['dateofbirth'];*/
        $Employee->dateofbirth = Carbon::createFromFormat('Y/m/d', $request['dateofbirth'])->toDateTimeString(); 
        $Employee->age = $request['age'];     
        $Employee->maritalstatus = $request['maritalstatus'];
        $Employee->noofchildren = $request['noofchildren'];
        $Employee->nationality = $request['nationality'];
        $Employee->bloodgroup = $request['bloodgroup'];
        $Employee->spousename = $request['spousename'];
        $Employee->phoneno = $request['phoneno'];
        $Employee->religion = $request['religion'];
        $Employee->denomination = $request['denomination'];
        $Employee->tribe = $request['tribe'];
        $Employee->genotype = $request['genotype'];
        $Employee->state = $request['state'];
        $Employee->title = $request['title'];
        $Employee->maidenname = $request['maidenname'];
        $Employee->formername = $request['formername'];
        $Employee->localgovermentoforigin = $request['localgovermentoforigin'];
        $Employee->disability = $request['disability'];
        //$Employee->disabilitytype = $request['disabilitytype'];
        if(isset($request['disability']) && $request['disability'] == 'Yes'){
            $Employee->disabilitytype = implode(',', $request['disabilitytype']);
        }
        $Employee->dateofdeath = $request['dateofdeath'];
        $Employee->causeofdeath = $request['causeofdeath'];

        // $Employee->institution_id = Auth::user()->id;
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
            $Employee->institution_id = Auth::user()->employee->institution_id;
        }else{
            $Employee->institution_id = Auth::user()->id;
        }


        $Employee->employeestatus = $request['employeestatus'];
        $Employee->reporting_employee_id = $request['reporting_employee_id'];
        if(isset($request->profile_image) && $request->profile_image != ''){
            $current = Carbon::now()->format('YmdHs');
            $image_parts = explode(";base64,", $request->profile_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
        
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.jpg';
            $file = $_SERVER['DOCUMENT_ROOT'].'/public/public/employee/' . $fileName;
            file_put_contents($file, $image_base64);
            $Employee->profile_image = $fileName;
        }

        // if ($request->hasFile('refereeconsentletter')) {
        //     $current = Carbon::now()->format('YmdHs');
        //     $refereeconsentletterfile = $request->file('refereeconsentletter')[$key];
        //     $refereeconsentletterfilename = $current . $refereeconsentletterfile->getClientOriginalName();
        //     $refereeconsentletterfile->move('public/files/', $refereeconsentletterfilename);
        // }
        
        $Employee->hometown = $request['hometown'];
        $Employee->country = $request['country'];
        $Employee->city = $request['city'];
        // dd($Employee);
        $Employee->save();
        $emp_id = $Employee->id;

        // $qrcode = $emp_id."-".$request['fname'];
        // $qrmsg = $emp_id."-".$request['fname'];       
        // $qrcodeimage = QrCode::size(500)
        //         ->format('png')
        //         ->generate($qrmsg, public_path().'/qrcodes/'.$qrcode.'.png');       
        // $Employee->qrcode = $qrcode.'.png';

        $Employee->update();

        $official_info = new OfficialInfo();
        $official_info->employee_id = $emp_id;
        $official_info->staff_id = $request['staff_id'];

        $new_so_number = substr($request['staff_id'], 2);

        $check_so = OfficialInfo::where('staff_id', $request['staff_id'])->first();
        //dd($check_so);        
        if (isset($check_so) && !empty($check_so)) {
            $official_info->staff_id = date('Y') . '' . $new_so_number + 1;
        } else {
            $official_info->staff_id = date('Y') . '' . $new_so_number;
        }
        //dd($official_info->staff_id);
        if(Auth::user()->category != ''){
            $official_info->category = Auth::user()->category;
        }else{
            $official_info->category = $request['category_unit'];
        }
        


        if($request['category_unit'] == 'Non-Academic' || Auth::user()->category == 'Non-Academic'){
            $official_info->non_Academic_department = $request['department_non_Academic'];
            $official_info->non_Academic_division = $request['division_non_Academic'];
            $official_info->non_Academic_designation = $request['designation_non_Academic'];
            $official_info->non_Academic_unit = $request['unit_non_Academic'];
            $official_info->non_Academic_role = $request['role_non_Academic'];

        }else{
            $official_info->directorate = $request['directorate'];
            $official_info->department = $request['department'];
            $official_info->designation = $request['designation'];
            $official_info->unit = $request['unit'];
            $official_info->role = $request['role'];
        }

    


        $official_info->cadre = $request['cadre'];
        $official_info->highestqualification = $request['highestqualification'];
        $official_info->gradelevel = $request['gradelevel'];
        $official_info->step = $request['step'];
        $official_info->areaofstudy = $request['areaofstudy'];
        $official_info->dateofemployment = Carbon::createFromFormat('d/m/Y', $request['dateofemployment'])->toDateTimeString();
        $official_info->expectedretirementdate = $request['expectedretirementdate'];
        $official_info->typeofemployment = $request['typeofemployment'];
        $official_info->officialinfoother = $request['officialinfoother'];
        $official_info->reporting_employee_id = $request['reporting_employee_id'];

        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
            $official_info->user_id = Auth::user()->employee->institution_id;
        }else{
            $official_info->user_id = Auth::user()->id;
        }
        
        // $official_info->user_id = Auth::user()->id;

        $official_info->save();

        $Residential = new Residential();
        $Residential->employee_id = $emp_id;
        $Residential->houseno = $request['houseno'];
        $Residential->streetname = $request['streetname'];
        $Residential->residentialcountry = $request['residentialcountry'];
        $Residential->residentialnationality = $request['residentialnationality'];
        $Residential->residentialstate = $request['residentialstate'];
        $Residential->localgoverment = $request['localgoverment'];
        $Residential->citytown = $request['citytown'];
        $Residential->phone_no_1 = $request['phone_no_1'];
        $Residential->phone_no_2 = $request['phone_no_2'];
        $Residential->email = $request['email'];
        // $Residential->user_id = Auth::user()->id;
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
            $Residential->user_id = Auth::user()->employee->institution_id;
        }else{
            $Residential->user_id = Auth::user()->id;
        }


        $Residential->save();
        $filename = NULL;
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $request->image->move('public/images/', $filename);
        }

        $Kin_detail = new Kin_detail();
        $Kin_detail->employee_id = $emp_id;
        $Kin_detail->name = $request['name'];
        $Kin_detail->relationship = $request['relationship'];
        $Kin_detail->phoneno = $request['phoneno'];
        $Kin_detail->kinemail = $request['kinemail'];
        $Kin_detail->address = $request['address'];
        $Kin_detail->kindetailssex = $request['kindetailssex'];
        $Kin_detail->image = $filename;
        // $Kin_detail->user_id = Auth::user()->id;
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU')){
            $Kin_detail->user_id = Auth::user()->employee->institution_id;
        }else{
            $Kin_detail->user_id = Auth::user()->id;
        }
        $Kin_detail->save();

        $acadamicqualification = new AcademicQualification();
        foreach ($request->institutionname as  $key => $value) {
            if ($request->hasFile('academic_upload')) {
                $current = Carbon::now()->format('YmdHs');
                $academic_uploadfile = $request->file('academic_upload')[$key];
                $academic_upload_name = $academic_uploadfile->getClientOriginalName();
                $academic_uploadfilename = $current . $academic_uploadfile->getClientOriginalName();
                $academic_uploadfile->move('public/files/', $academic_uploadfilename);
            }

            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU')){
                $Academic_user = Auth::user()->employee->institution_id;
            }else{
                $Academic_user = Auth::user()->id;
            }

            $data = array(
                'user_id' => $Academic_user,
                'employee_id' => $emp_id,
                'institutionname' => $request->institutionname[$key],
                'institutioncategory' => $request->institutioncategory[$key],
                'certificateobtained' => $request->certificateobtained[$key],
                'programmeduration' => $request->programmeduration[$key],
                'programmedurationenddate' => $request->programmedurationenddate[$key],
                'postheldandprojecthandled' => $request->postheldandprojecthandled[$key],
                'academicother' => $request->academicother[$key],
                'courseofstudy' => $request->courseofstudy[$key],
                'acaduration' => $request->acaduration[$key],
                'academic_upload' => $academic_uploadfilename,
                'academic_upload_name' => $academic_upload_name
            );
            AcademicQualification::create($data);
        }

        $work_experience = new WorkExperience();
        $work_experience->employee_id = $emp_id;
        $work_experience->user_id = Auth::user()->id;
        foreach ($request->workinstitutionname as  $key => $value) {
            if($request->category_unit_work_experience[$key] == 'Non-Academic' || Auth::user()->category == 'Non-Academic'){
                $workdepartment = '';
                $workdesignation = '';
                $non_academic_workdepartment = $request->workdepartment_non_academic[$key];
                $non_academic_workdesignation = $request->workdepartment_non_academic[$key];

            }else{
                $non_academic_workdepartment = '';
                $non_academic_workdesignation = '';
                $workdepartment = $request->workdepartment[$key];
                $workdesignation = $request->workdesignation[$key];
            }
            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
                $WorkExperience_user_id = Auth::user()->employee->institution_id;
            }else{
                $WorkExperience_user_id = Auth::user()->id;
            }

            $data = array(
                'user_id' => $WorkExperience_user_id,
                'employee_id' => $emp_id,
                'workinstitutionname' => $request->workinstitutionname[$key],
                'workstartdate' => $request->workstartdate[$key],
                'workenddate' => $request->workenddate[$key],
                'workduration' => $request->workduration[$key],
                'category' => $request->category_unit_work_experience[$key],
                'workdepartment' => $workdepartment,
                'workdesignation' => $workdesignation,
                'non_academic_workdepartment' => $non_academic_workdepartment,
                'non_academic_workdesignation' => $non_academic_workdesignation,
                'workpostheld' => $request->workpostheld[$key],
                'workgradelevel' => $request->workgradelevel[$key],
                'workstep' => $request->workstep[$key],
                'workcadre' => $request->workcadre[$key]
            );
            WorkExperience::create($data);
        }

        $salary_details = new SalaryDetails();
        $salary_details->employee_id = $emp_id;
        $salary_details->bankname = $request->bankname;
        $salary_details->accountname = $request->accountname;
        if ($request->hasFile('uploadidcard')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadidcardfile = $request->file('uploadidcard');
            $uploadidcard = $current . $uploadidcardfile->getClientOriginalName();
            $uploadidcardfile->move('public/id_cards/', $uploadidcard);
            $salary_details->uploadidcard = $uploadidcard;
        }
        $salary_details->accountnumber = $request->accountnumber;
        $salary_details->bvn = $request->bvn;
        $salary_details->tin = $request->tin;
        // $salary_details->user_id = Auth::user()->id;
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
            $salary_details->user_id = Auth::user()->employee->institution_id;
        }else{
            $salary_details->user_id = Auth::user()->id;
        }
        $salary_details->save();

        $Referee_info = new RefereeInfo();
        $Referee_info->employee_id = $emp_id;
        $Referee_info->user_id = Auth::user()->id;
        foreach ($request->referee_info_fullname as  $key => $value) {
            if ($request->hasFile('refereeconsentletter')) {
                $current = Carbon::now()->format('YmdHs');
                $refereeconsentletterfile = $request->file('refereeconsentletter')[$key];
                $refereeconsentletterfilename = $current . $refereeconsentletterfile->getClientOriginalName();
                $refereeconsentletterfile->move('public/files/', $refereeconsentletterfilename);
            }
            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
                $referee_user_id = Auth::user()->employee->institution_id;
            }else{
                $referee_user_id = Auth::user()->id;
            }
            $data = array(
                'user_id' => $referee_user_id,
                'employee_id' => $emp_id,
                'referee_info_fullname' => $request->referee_info_fullname[$key],
                'referee_info_occupation' => $request->referee_info_occupation[$key],
                'referee_info_postheld' => $request->referee_info_postheld[$key],
                'referee_info_address' => $request->referee_info_address[$key],
                'referee_info_phoneno' => $request->referee_info_phoneno[$key],
                'referee_info_email' => $request->referee_info_email[$key],
                'refereeconsentletter' => $refereeconsentletterfilename
            );
            RefereeInfo::create($data);
            $email = User::where('email', '=', $request->input('employeeemail'))->first();      
            if ($email != '') {
                return redirect()->route('add.employee')->with('error',"Email address is already Exits.");
            }
            else{
                $Employeeuser = new User;
                $request->merge([
                    'is_school' => 3,
                ]);
                $datauser['is_school'] = $request['is_school'];
                $datauser['email'] = $request['employeeemail'];
                $datauser['password'] = Hash::make($request['password']);
                if($request['category_unit'] == 'Non-Academic' || Auth::user()->category == 'Non-Academic'){
                    $datauser['role'] = $request['role_non_Academic'];
                }else{
                    $datauser['role'] = $request['role'];
                }
                
                if(Auth::user()->category != ''){
                    $datauser['category'] = Auth::user()->category;

                }else{
                    $datauser['category'] = $request['category_unit'];
                }
                

                $Employeeuser = $Employeeuser->create($datauser);

                $employee_dt = Employee::findOrFail($emp_id);
                $employee_dt->user_id = $Employeeuser->id;
                $employee_dt->update();
            }
            //Mail::to($request->referee_info_email[$key])->send(new ContactMail($data));
        }

        $certificates = new Certificate();
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOF' || Auth::user()->role == 'HOU')){
            $certificates->user_id = Auth::user()->employee->institution_id;
        }else{
            $certificates->user_id = Auth::user()->id;
        }
        $certificates->employee_id = $emp_id;
        // $certificates->user_id = Auth::user()->id;
        if ($request->hasFile('birthcerticate')) {
            $current = Carbon::now()->format('YmdHs');
            $birthcerticatefile = $request->file('birthcerticate');
            $birthcerticate = $current . $birthcerticatefile->getClientOriginalName();
            $birthcerticatefile->move('public/id_cards/', $birthcerticate);
            $certificates->birthcerticate = $birthcerticate;
        }
        if ($request->hasFile('professionalcertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $professionalcertificatefile = $request->file('professionalcertificate');
            $professionalcertificate = $current . $professionalcertificatefile->getClientOriginalName();
            $professionalcertificatefile->move('public/id_cards/', $professionalcertificate);
            $certificates->professionalcertificate = $professionalcertificate;
        }
        if ($request->hasFile('marriagecertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $marriagecertificatefile = $request->file('marriagecertificate');
            $marriagecertificate = $current . $marriagecertificatefile->getClientOriginalName();
            $marriagecertificatefile->move('public/id_cards/', $marriagecertificate);
            $certificates->marriagecertificate = $marriagecertificate;
        }
        if ($request->hasFile('awardandhonorarycertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $awardandhonorarycertificatefile = $request->file('awardandhonorarycertificate');
            $awardandhonorarycertificate = $current . $awardandhonorarycertificatefile->getClientOriginalName();
            $awardandhonorarycertificatefile->move('public/id_cards/', $awardandhonorarycertificate);
            $certificates->awardandhonorarycertificate = $awardandhonorarycertificate;
        }
        if ($request->hasFile('othercertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $othercertificatefile = $request->file('othercertificate');
            $othercertificate = $current . $othercertificatefile->getClientOriginalName();
            $othercertificatefile->move('public/id_cards/', $othercertificate);
            $certificates->othercertificate = $othercertificate;
        }
        if ($request->hasFile('deathcertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $deathcertificatefile = $request->file('deathcertificate');
            $deathcertificate = $current . $deathcertificatefile->getClientOriginalName();
            $deathcertificatefile->move('public/id_cards/', $deathcertificate);
            $certificates->deathcertificate = $deathcertificate;
        }
        $certificates->certificatename = isset($request['certificatename']) ? $request['certificatename'] : '';
        
        $certificates->save();

        if ($Referee_info)
            return redirect()->route('employee.list')->with('success', 'Employee Added Successfully');
        else
            return redirect()->route('add1.employee')->with('errror', 'Error In Adding Employee');
    }

    public function index()
    {
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOU' || Auth::user()->role == 'HOS')){
            // $data = Employee::where('institution_id', '=', Auth::user()->employee->institution_id)->orderBy('id', 'DESC')->official_information('non_Academic_department','=', Auth::user()->employee->official_information->non_Academic_department)->get();
            $data = Employee::where('institution_id', Auth::user()->employee->institution_id)
                    ->whereHas('official_information', function($query) {
                        $query->where('non_Academic_department', Auth::user()->employee->official_information->non_Academic_department)
                            ->Where('role', '!=', Auth::user()->role)
                            ->Where('category', Auth::user()->category);
                     })
                    ->orderBy('id', 'DESC')
                    ->get();
            // $employeecount = Employee::where('institution_id', '=', Auth::user()->employee->institution_id)->count();
            $employeecount = Employee::where('institution_id', Auth::user()->employee->institution_id)
                            ->whereHas('official_information', function($query) {
                                $query->where('non_Academic_department', Auth::user()->employee->official_information->non_Academic_department)
                                ->where('category', Auth::user()->category)
                                ->orWhere('role', '!=',Auth::user()->role);

                            })
                            ->orderBy('id', 'DESC')
                            ->count();
        }else{
            $data = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $employeecount = Employee::where('institution_id', '=', Auth::user()->id)->count();
        }
     
        
        
        // $data = Employee::where('institution_id', '=', Auth::user()->id)
        //     ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
        //     ->orderBy('employees.id', 'DESC')
        //     ->get();
        // $employeecount = Employee::where('institution_id', '=', Auth::user()->id)->count();
        // $datas = $data['department'];
        // dd($datas);

        
        
        return view('employee/index', compact('data', 'employeecount'));
    }

    public function edit($id)
    {
        $data = Employee::where('institution_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $employee = Employee::findOrFail($id);
        $acadamicdata = AcademicQualification::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        $workdata = WorkExperience::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        $refeedata = RefereeInfo::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        //$departments = Department::get();
        $departments = Department::where('user_id','=',Auth::user()->id)->get();
        $designations = Designation::where('user_id','=',Auth::user()->id)->get();
        $units = Unit::where('user_id','=',Auth::user()->id)->get();
        $facultydirectorates = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $countries = Country::get();
        $nationalities = Nationality::get();
        $kin_details = Kin_detail::get();
        $localgovermentoforigins = LocalGovernment::get();
        $states = State::get();
        $stateoforigins = StateOrigin::get();

        if(Auth::user()->category == 'Non-Academic' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV')){
            $non_academic_departments = NonAcademicsDepartment::where('id','=',Auth::user()->employee->official_information->non_Academic_department)->get();
            $division = Division::where('user_id','=',Auth::user()->id)->get();
            $non_academic_units = NonAcademicUnit::where('user_id','=',Auth::user()->id)->get();
            $non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();
            $work_non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->employee->institution_id)->get();
            $work_non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->employee->institution_id)->get();


        }else{
            $non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->id)->get();
            $work_non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->id)->get();

            $division = Division::where('user_id','=',Auth::user()->id)->where('faculty_id', $employee->official_information->non_Academic_department)->get();
            $non_academic_units = NonAcademicUnit::where('user_id','=',Auth::user()->id)->where('faculty_id', $employee->official_information->non_Academic_department)->get();
            $non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->where('faculty_id', $employee->official_information->non_Academic_department)->get();
            $work_non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();

        }

        // $non_academic_departments = NonAcademicsDepartment::where('user_id','=',Auth::user()->id)->get();
        // $division = Division::where('user_id','=',Auth::user()->id)->get();
        // $non_academic_units = NonAcademicUnit::where('user_id','=',Auth::user()->id)->get();
        // $non_academic_designations = NonAcademicsDesignation::where('user_id','=',Auth::user()->id)->get();

        // dd($employee->official_information);

        return view('employee/add1', compact('employee', 'id', 'acadamicdata', 'workdata', 'refeedata', 'departments', 'designations', 'facultydirectorates', 'countries', 'nationalities', 'kin_details', 'localgovermentoforigins', 'states', 'stateoforigins', 'units','data','non_academic_departments','division','non_academic_units','non_academic_designations', 'work_non_academic_departments', 'work_non_academic_designations'));
    }

    public function update(Request $request, $id)
    {

        $emp_id = $id;
        $Employee = Employee::findOrFail($id);
        $Employee->fname = $request['fname'];
        $Employee->mname = $request['mname'];
        $Employee->lname = $request['lname'];
        $old_email = $Employee->employeeemail;
        $Employee->employeeemail = $request['employeeemail'];
        if(isset($request['password']) && $request['password'] != ''){
            $Employee->password = $request['password'];
        }
        $Employee->sex   = $request['sex'];
        $Employee->otherfield = $request['otherfield'];
        //$Employee->dateofbirth = $request['dateofbirth'];
        $Employee->dateofbirth = Carbon::createFromFormat('Y/m/d', $request['dateofbirth'])->toDateTimeString(); 
        $Employee->age = $request['age'];
        $Employee->maritalstatus = $request['maritalstatus'];
        $Employee->noofchildren = $request['noofchildren'];
        $Employee->nationality = $request['nationality'];
        $Employee->bloodgroup = $request['bloodgroup'];
        $Employee->spousename = $request['spousename'];
        $Employee->phoneno = $request['phoneno'];
        $Employee->religion = $request['religion'];
        $Employee->denomination = $request['denomination'];
        $Employee->tribe = $request['tribe'];
        $Employee->genotype = $request['genotype'];
        $Employee->state = $request['state'];
        $Employee->localgovermentoforigin = $request['localgovermentoforigin'];
        $Employee->hometown = $request['hometown'];
        $Employee->country = $request['country'];
        $Employee->city = $request['city'];
        $Employee->title = $request['title'];
        $Employee->maidenname = $request['maidenname'];
        $Employee->formername = $request['formername'];
        $Employee->disability = $request['disability'];
        if(isset($request['disability']) && $request['disability'] == 'Yes'){
            $Employee->disabilitytype = implode(',', $request['disabilitytype']);
        }
        $Employee->dateofdeath = $request['dateofdeath'];
        $Employee->causeofdeath = $request['causeofdeath'];
        $Employee->employeestatus = $request['employeestatus'];
        $Employee->reporting_employee_id = $request['reporting_employee_id'];
        if(isset($request->profile_image) && $request->profile_image != ''){
            $current = Carbon::now()->format('YmdHs');
            $image_parts = explode(";base64,", $request->profile_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
        
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $file = $_SERVER['DOCUMENT_ROOT'].'/public/public/employee/' . $fileName;
            file_put_contents($file, $image_base64);
            $Employee->profile_image = $fileName;
        }
        // $qrcode = $id."-".$request['fname'];
        // $qrmsg = $id."-".$request['fname'];       
        // $qrcodeimage = QrCode::size(500)
        //         ->format('png')
        //         ->generate($qrmsg, public_path().'/qrcodes/'.$qrcode.'.png');       
        // $Employee->qrcode = $qrcode.'.png';
        $Employee->update();

        $official_infos = OfficialInfo::where('employee_id', '=', $id)->first();


        if(Auth::user()->category != ''){
            $official_infos->category = Auth::user()->category;
        }else if($request['department_non_Academic'] != ''){
            $official_infos->category = 'Non-Academic';
        }else if($request['department'] != ""){
            $official_infos->category = 'Academic';
        }else{
            $official_infos->category = $request['category_unit'];

        }


        if($request['category_unit'] == 'Non-Academic' || $request['department_non_Academic'] != '' || Auth::user()->category != 'Non-Academic'){
            $official_infos->non_Academic_department = $request['department_non_Academic'];
            $official_infos->non_Academic_division = $request['division_non_Academic'];
            $official_infos->non_Academic_designation = $request['designation_non_Academic'];
            $official_infos->non_Academic_unit = $request['unit_non_Academic'];
            $official_infos->non_Academic_role = $request['role_non_Academic'];
            $official_infos->role = $request['role_non_Academic'];


        }else{
            $official_infos->directorate = $request['directorate'];
            $official_infos->department = $request['department'];
            $official_infos->designation = $request['designation'];
            $official_infos->unit = $request['unit'];
            $official_infos->role = $request['role'];
        }
        $official_infos->directorate = $request['directorate'];
        $official_infos->department = $request['department'];
        $official_infos->designation = $request['designation'];
        $official_infos->cadre = $request['cadre'];
        $official_infos->highestqualification = $request['highestqualification'];
        $official_infos->gradelevel = $request['gradelevel'];
        $official_infos->step = $request['step'];
        $official_infos->areaofstudy = $request['areaofstudy'];
        $official_infos->dateofemployment = Carbon::createFromFormat('d/m/Y', $request['dateofemployment'])->toDateTimeString();
        $official_infos->expectedretirementdate = $request['expectedretirementdate'];
        $official_infos->unit = $request['unit'];
        $official_infos->typeofemployment = $request['typeofemployment'];
        $official_infos->officialinfoother = $request['officialinfoother'];
        // $official_infos->role = $request['role'];
        $official_infos->reporting_employee_id = $request['reporting_employee_id'];



        // $official_infos = OfficialInfo::where('employee_id', '=', $id)->first();
        // $data = $request->input();
        // $data['dateofemployment'] = Carbon::createFromFormat('d/m/Y', $data['dateofemployment'])->toDateTimeString();
        //$official_info->expectedretirementdate = $request['expectedretirementdate'];
        // dd($data);
        $official_infos->update();

        $Residential = Residential::where('employee_id', '=', $id)->first();
        $Residential->houseno = $request['houseno'];
        $Residential->streetname = $request['streetname'];
        $Residential->residentialcountry = $request['residentialcountry'];
        $Residential->residentialnationality = $request['residentialnationality'];
        $Residential->residentialstate = $request['residentialstate'];
        $Residential->localgoverment = $request['localgoverment'];
        $Residential->citytown = $request['citytown'];
        $Residential->phone_no_1 = $request['phone_no_1'];
        $Residential->phone_no_2 = $request['phone_no_2'];
        $Residential->email = $request['email'];

        // $Residential->user_id = Auth::user()->id;
        if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
            $Residential->user_id = Auth::user()->employee->institution_id;
        }else{
            $Residential->user_id = Auth::user()->id;
        }

        $Residential->update();

        $Kin_detail = Kin_detail::where('employee_id', '=', $id)->first();
        $Kin_detail->name = $request['name'];
        $Kin_detail->relationship = $request['relationship'];
        $Kin_detail->phoneno = $request['phoneno'];
        $Kin_detail->kinemail = $request['kinemail'];
        $Kin_detail->address = $request['address'];
        if ($request->hasFile('image')) {
            $Kin_details = 'public/images/' . '$Kin_detail->image';
            if (File::exists($Kin_details)) {
                File::delete($Kin_details);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move('public/images/', $filename);
            $Kin_detail->image = $filename;
        }
        $Kin_detail->update();
        $AcademicQualification = AcademicQualification::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        $data1 = [];
        foreach ($AcademicQualification as  $key => $value) {
            $data1[$key] = $value->id;
        }  
        //dd($request->institutionname);
        foreach ($request->institutionname as  $key => $value) {
            
            if (isset($request->inst_id[$key])) {
                $acd_id = $request->inst_id[$key];                
            }    
            else{
                $acd_id = '';
            }  
            
            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
                $user_id = Auth::user()->employee->institution_id;
            }else{
                $user_id = Auth::user()->id;
            }
            if (in_array($acd_id, $data1)) {                
                $AcademicQualification = AcademicQualification::where('id', '=', $acd_id)->first();
                if(isset($AcademicQualification)) {
                    $academic_uploadfilename = $AcademicQualification->academic_upload;
                    $academic_upload_name = $AcademicQualification->academic_upload_name;
                    if ($request->hasFile('academic_upload')) {
                        if(isset($request->file('academic_upload')[$key])){
                            $current = Carbon::now()->format('YmdHs');
                            $academic_uploadfile = $request->file('academic_upload')[$key];
                            $academic_upload_name = $academic_uploadfile->getClientOriginalName();                            
                            $academic_uploadfilename = $current . $academic_uploadfile->getClientOriginalName();                            
                            $academic_uploadfile->move('public/files/', $academic_uploadfilename);
                        }
                    }                
                $acadamydata = array(
                    'institutionname' => $request->institutionname[$key],
                    'institutioncategory' => $request->institutioncategory[$key],
                    'courseofstudy' => $request->courseofstudy[$key],
                    'certificateobtained' => $request->certificateobtained[$key],
                    'programmeduration' => $request->programmeduration[$key],
                    'programmedurationenddate' => $request->programmedurationenddate[$key],
                    //'experienceorproject' => $request->experienceorproject[$key],
                    'acaduration' => $request->acaduration[$key],
                    'postheldandprojecthandled' => $request->postheldandprojecthandled[$key],
                    'academicother' => $request->academicother[$key],
                    //'courseofstudy' => $courseofstudyname
                    'acaduration' => $request->acaduration[$key],
                    'academic_upload' => $academic_uploadfilename,
                    'academic_upload_name' => $academic_upload_name
                );
                $AcademicQualification->update($acadamydata);                
                }
                $acd_id = '';
            } else {                 
                if ($request->hasFile('academic_upload')) {
                    if(isset($request->file('academic_upload')[$key])){
                        $current = Carbon::now()->format('YmdHs');
                        $academic_uploadfile = $request->file('academic_upload')[$key];
                        $academic_upload_name = $academic_uploadfile->getClientOriginalName();
                        $academic_uploadfilename = $current . $academic_uploadfile->getClientOriginalName();
                        
                        $academic_uploadfile->move('public/files/', $academic_uploadfilename);
                    }
                }
                $data = array(
                    'user_id' => $user_id,
                    'employee_id' => (int)$emp_id,
                    'institutionname' => $request->institutionname[$key],
                    'institutioncategory' => $request->institutioncategory[$key],
                    'courseofstudy' => $request->courseofstudy[$key],
                    'certificateobtained' => $request->certificateobtained[$key],
                    'programmeduration' => $request->programmeduration[$key],
                    'programmedurationenddate' => $request->programmedurationenddate[$key],
                    /*'experienceorproject' => $request->experienceorproject[$key],*/
                    'acaduration' => $request->acaduration[$key],
                    'postheldandprojecthandled' => $request->postheldandprojecthandled[$key],
                    'academicother' => $request->academicother[$key],
                    //'courseofstudy' => $courseofstudyname
                    'academic_upload' => $academic_uploadfilename,
                    'academic_upload_name' => $academic_upload_name

                );
                AcademicQualification::create($data);                
            }
        }        
        $WorkExperience = WorkExperience::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        
        $data2 = [];
        foreach ($WorkExperience as  $key => $value) {
            $data2[$key] = $value->id;
        }
                  
        foreach ($request->workinstitutionname as  $key => $value) {

            if(Auth::user()->category != '' && (Auth::user()->role == 'HOD' || Auth::user()->role == 'HODV' || Auth::user()->role == 'HOS' || Auth::user()->role == 'HOU')){
                $work_user_id = Auth::user()->employee->institution_id;
            }else{
                $work_user_id = Auth::user()->id;
            }
            if($request->category_unit_work_experience[$key] == 'Non-Academic'){
                $workdepartment = '';
                $workdesignation = '';
                $non_academic_workdepartment = $request->workdepartment_non_academic[$key];
                $non_academic_workdesignation = $request->workdepartment_non_academic[$key];

            }else{
                $non_academic_workdepartment = '';
                $non_academic_workdesignation = '';
                $workdepartment = $request->workdepartment[$key];
                $workdesignation = $request->workdesignation[$key];
            }
            if (isset($request->work_id[$key])) {
                $acd_id = $request->work_id[$key];
            }          
            if (in_array($acd_id, $data2)) {
                //dd($data);
                //echo $acd_id."<br>";
                $WorkExperience = WorkExperience::where('id', '=', $acd_id)->first();
                //$AcademicQualification = AcademicQualification::findOrFail($acd_id)->first();
                $workdata = array(
                    'workinstitutionname' => $request->workinstitutionname[$key],
                    'workstartdate' => $request->workstartdate[$key],
                    'workenddate' => $request->workenddate[$key],
                    'workduration' => $request->workduration[$key],
                    'workdepartment' => $workdepartment,
                    'workdesignation' => $workdesignation,
                    'non_academic_workdepartment' => $non_academic_workdepartment,
                    'non_academic_workdesignation' => $non_academic_workdesignation,
                    'workpostheld' => $request->workpostheld[$key],
                    'workgradelevel' => $request->workgradelevel[$key],
                    'workstep' => $request->workstep[$key],
                    'workcadre' => $request->workcadre[$key]
                );
                //dd($acadamydata);
                $WorkExperience->update($workdata);
                $acd_id = '';
            } else {
                $data = array(
                    'user_id' => $work_user_id,
                    'employee_id' => $emp_id,
                    'workinstitutionname' => $request->workinstitutionname[$key],
                    'workstartdate' => $request->workstartdate[$key],
                    'workenddate' => $request->workenddate[$key],
                    'workduration' => $request->workduration[$key],
                    'workdepartment' => $workdepartment,
                    'workdesignation' => $workdesignation,
                    'non_academic_workdepartment' => $non_academic_workdepartment,
                    'non_academic_workdesignation' => $non_academic_workdesignation,
                    'workpostheld' => $request->workpostheld[$key],
                    'workgradelevel' => $request->workgradelevel[$key],
                    'workstep' => $request->workstep[$key],
                    'workcadre' => $request->workcadre[$key]
                );
            
                WorkExperience::create($data);
            }
        }


        $SalaryDetails = SalaryDetails::where('employee_id', '=', $id)->first();
        $data = $request->input();
        if ($request->hasFile('uploadidcard')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadidcardfile = $request->file('uploadidcard');
            $uploadidcard = $current . $uploadidcardfile->getClientOriginalName();
            $uploadidcardfile->move('public/id_cards/', $uploadidcard);
            $data['uploadidcard'] = $uploadidcard;
        }
        $SalaryDetails->update($data);


        $RefereeInfo = RefereeInfo::select('*')
            ->where('employee_id', '=', $id)
            ->get();
        
        $data3 = [];
        foreach ($RefereeInfo as  $key => $value) {
            $data3[$key] = $value->id;
        }

        foreach ($request->referee_info_fullname as  $key => $value) {
            if (isset($request->referee_id[$key])) {
                $acd_id = $request->referee_id[$key];
            }      
            if (in_array($acd_id, $data3)) {
                $RefereeInfo = RefereeInfo::where('id', '=', $acd_id)->first();
                $refereeconsentletterfilename = $RefereeInfo->refereeconsentletter;
                if ($request->hasFile('refereeconsentletter')) {
                    if(isset($request->file('refereeconsentletter')[$key])){
                        $current = Carbon::now()->format('YmdHs');
                        $refereeconsentletterfile = $request->file('refereeconsentletter')[$key];
                        $refereeconsentletterfilename = $current . $refereeconsentletterfile->getClientOriginalName();
                        
                        $refereeconsentletterfile->move('public/files/', $refereeconsentletterfilename);
                    }
                }
                $refeedata = array(
                    'referee_info_fullname' => $request->referee_info_fullname[$key],
                    'referee_info_occupation' => $request->referee_info_occupation[$key],
                    'referee_info_postheld' => $request->referee_info_postheld[$key],
                    'referee_info_address' => $request->referee_info_address[$key],
                    'referee_info_phoneno' => $request->referee_info_phoneno[$key],
                    'referee_info_email' => $request->referee_info_email[$key],
                    'refereeconsentletter' => $refereeconsentletterfilename
                );
                $RefereeInfo->update($refeedata);
                $acd_id = '';
            } else {
                if ($request->hasFile('refereeconsentletter')) {
                    $current = Carbon::now()->format('YmdHs');
                    $refereeconsentletterfile = $request->file('refereeconsentletter')[$key];
                    $refereeconsentletterfilename = $current . $refereeconsentletterfile->getClientOriginalName();
                    
                    $refereeconsentletterfile->move('public/files/', $refereeconsentletterfilename);
                }
                $data = array(
                    'user_id' => Auth::user()->id,
                    'employee_id' => $emp_id,
                    'referee_info_fullname' => $request->referee_info_fullname[$key],
                    'referee_info_occupation' => $request->referee_info_occupation[$key],
                    'referee_info_postheld' => $request->referee_info_postheld[$key],
                    'referee_info_address' => $request->referee_info_address[$key],
                    'referee_info_phoneno' => $request->referee_info_phoneno[$key],
                    'referee_info_email' => $request->referee_info_email[$key],
                    'refereeconsentletter' => $refereeconsentletterfilename
                );
                RefereeInfo::create($data);
            }
        }

        $users = User::where('email', '=', $Employee->employeeemail)->first(); 
                $userfind=Auth::user()->id;
                $empUpdate = Employee::findOrFail($emp_id);
                
                $userUpdate= User::where('id',$empUpdate->user_id)->first();
                $userUpdate->email = $request['employeeemail'];
                if($request['category_unit'] == 'Non-Academic'){
                    $userUpdate->role = $request['role_non_Academic'];
                }else{
                    $userUpdate->role = $request['role'];
                }
                if(isset($request['password']) && $request['password'] != ''){
                    $userUpdate->password = Hash::make($request['password']);
                }
                $userUpdate->role = $request['role'];
                // dd($userUpdate);
                $userUpdate->update();
            
        // if(isset($users)){
        //     $users->delete();
        // }
        $update = false;
        $certificates = Certificate::where('employee_id', '=', $emp_id)->first();
        if(!$certificates){
            $certificates = new Certificate();
            $create = true;
        }
    
        if ($request->hasFile('birthcerticate')) {
            $current = Carbon::now()->format('YmdHs');
            $birthcerticatefile = $request->file('birthcerticate');
            $birthcerticate = $current . $birthcerticatefile->getClientOriginalName();
            $birthcerticatefile->move('public/id_cards/', $birthcerticate);
            $certificates->birthcerticate = $birthcerticate;
            $update = true;
        }
        if ($request->hasFile('professionalcertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $professionalcertificatefile = $request->file('professionalcertificate');
            $professionalcertificate = $current . $professionalcertificatefile->getClientOriginalName();
            $professionalcertificatefile->move('public/id_cards/', $professionalcertificate);
            $certificates->professionalcertificate = $professionalcertificate;
            $update = true;
        }
        if ($request->hasFile('marriagecertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $marriagecertificatefile = $request->file('marriagecertificate');
            $marriagecertificate = $current . $marriagecertificatefile->getClientOriginalName();
            $marriagecertificatefile->move('public/id_cards/', $marriagecertificate);
            $certificates->marriagecertificate = $marriagecertificate;
            $update = true;
        }
        if ($request->hasFile('awardandhonorarycertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $awardandhonorarycertificatefile = $request->file('awardandhonorarycertificate');
            $awardandhonorarycertificate = $current . $awardandhonorarycertificatefile->getClientOriginalName();
            $awardandhonorarycertificatefile->move('public/id_cards/', $awardandhonorarycertificate);
            $certificates->awardandhonorarycertificate = $awardandhonorarycertificate;
            $update = true;
        }
        if ($request->hasFile('othercertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $othercertificatefile = $request->file('othercertificate');
            $othercertificate = $current . $othercertificatefile->getClientOriginalName();
            $othercertificatefile->move('public/id_cards/', $othercertificate);
            $certificates->othercertificate = $othercertificate;
            $update = true;
        }
        if ($request->hasFile('deathcertificate')) {
            $current = Carbon::now()->format('YmdHs');
            $deathcertificatefile = $request->file('deathcertificate');
            $deathcertificate = $current . $deathcertificatefile->getClientOriginalName();
            $deathcertificatefile->move('public/id_cards/', $deathcertificate);
            $certificates->deathcertificate = $deathcertificate;
            $update = true;
        }
        $certificates->certificatename = isset($request['certificatename']) ? $request['certificatename'] : '';
        if(isset($create)){
            $certificates->id = $emp_id;
            $certificates->create();
        }
        else if($update){
            $certificates->update();
        }
        if ($RefereeInfo)
            return redirect()->route('employee.list')->with('success', "Employee Update Successfully");
        else
            return redirect()->route('employee.list')->with('error', "Error In Updating Employee");
    }

    public function removeDealers()
    {
        if (isset($_POST['data_dealers_buy']) && !empty($_POST['data_dealers_buy'])) {
            $data_dealers_buy = $_POST['data_dealers_buy'];
            AcademicQualification::where('id', $data_dealers_buy)->delete();
        }
    }

    public function removeworkexp()
    {
        if (isset($_POST['data_dealers_buy_workexp']) && !empty($_POST['data_dealers_buy_workexp'])) {
            $data_dealers_buy_workexp = $_POST['data_dealers_buy_workexp'];
            WorkExperience::where('id', $data_dealers_buy_workexp)->delete();
        }
    }
    public function removerefree()
    {
        if (isset($_POST['data_dealers_buy_removerefree']) && !empty($_POST['data_dealers_buy_removerefree'])) {
            $data_dealers_buy_removerefree = $_POST['data_dealers_buy_removerefree'];
            RefereeInfo::where('id', $data_dealers_buy_removerefree)->delete();
        }
    }

    public function delete($code)
    {
        $employee = Employee::where('id', '=', $code)->first();
        $empemail = $employee->id;
        $resi_emp = Residential::where('employee_id', '=', $empemail)->first();        
        $deleteuser = User::where('email', '=', $employee->employeeemail)->first();
        if(isset($deleteuser)){
            $deleteuser->delete();
        }

        if(isset($employee)){
            $employee->delete();
        }
        
        return redirect()->route('employee.list')->with('success', "Employee Deleted Successfully.");
    }

    // Status Update
    public function statusUpdate()
    {
        if (isset($_POST['data_employeeid']) && !empty($_POST['data_employeeid'])) {
            $Employee_id = $_POST['data_employeeid'];
            $employee = Employee::where('id', $Employee_id)->first();
            Employee::where('id', $Employee_id)->update([ 'status' => $_POST['data_status'] ]);            
            $resi_emp = Residential::where('employee_id', '=', $Employee_id)->first();        
            $disableuser = User::where('email', '=', $employee->employeeemail)->first();
            if(isset($disableuser)){
                User::where('email', $disableuser->email)->update([ 'status' => $_POST['data_status'] ]);
            }
            echo json_encode( [ 'status' => 'success' ] );
        } else {
            echo json_encode(['status' => 'error']);
        }
        die;
    }

    public function daily_report(Request $request)
    {
        $from_date_val = null;
        $end_date_val = null;
        $age_val = null;
        $qua_val = null;
        if (isset($request->from_date) && isset($request->end_date)) {
            $from_date_val = $request->from_date;
            $end_date_val = $request->end_date;
            $from_date = Carbon::parse($request->from_date)->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)->toDateTimeString();
            // $data = OfficialInfo::whereBetween('dateofemployment', [$from_date."Y-m-d", $end_date."Y-m-d"])->get();
            $data = OfficialInfo::whereBetween('dateofemployment', [$from_date . "Y-m-d", $end_date . "Y-m-d"])->pluck('employee_id')->toArray();
            // dd($data);
        } else {
            $data = OfficialInfo::pluck('employee_id')->toArray();
        }

        $qul = [];
        //dd($qul);

        if (isset($request->qualification) && $request->qualification != null) {
            $qua_val = $request->qualification;
            $qul = AcademicQualification::select('employee_id')->where('certificateobtained', 'LIKE', '%' . $request->qualification . '%')->pluck('employee_id')->toArray();
        }
        //dd($request->qualification);

        if (isset($request->age) && $request->age != null) {
            $age_val = $request->age;
        }

        $data = array_unique(array_intersect($data, $qul));

        //dd($data);
        // $employeecount = Employee::where('user_id','=',Auth::user()->id)->count();
        $employeecount = count($data);
        $collection = collect(new Employee);
        foreach ($data as $key => $value) {
            //$emp_id = $value->employee_id;
            $emp = Employee::where('id', $value)->first();
            if (isset($request->age) && $request->age != null) {
                $age = Carbon::parse($emp->dateofbirth)->diff(Carbon::now())->y;
                if ($request->age == $age) {
                    $collection->put($key, $emp);
                }
            } else {
                $collection->put($key, $emp);
            }
        }

        $data = $collection;
        return view('employee/index', compact('data', 'employeecount', 'age_val', 'qua_val', 'from_date_val', 'end_date_val'));
    }

    public function export() {
        $data = Employee::where('user_id', '=', Auth::user()->id)->get();
        $data_ar = [];
        foreach($data as $key=>$Employee){
            $data_ar[$key]['#No'] = $key;
            $data_ar[$key]['Staff_id'] = isset($Employee->official_information)? strval($Employee->official_information->staff_id) : '-';
            $data_ar[$key]['Department'] =isset($Employee->official_information) ? $Employee->official_information->department : '';
            $data_ar[$key]['Phone'] = $Employee->phoneno;
            $data_ar[$key]['Email'] = isset($Employee->employeeemail) ? $Employee->employeeemail : '';
            $data_ar[$key]['Faculty'] = $Employee->faculty;
            $data_ar[$key]['Designation'] = isset($Employee->official_information) ? $Employee->official_information->designation : '';
            $data_ar[$key]['Date Of Employment'] = isset($Employee->official_information) ? $Employee->official_information->dateofemployment->format('m/d/Y'):'';
        }
        echo json_encode($data_ar);
        die;
    }

    /* Employe History start */
    public function history() { 
        $historyemployee = Employee::where('employees.institution_id','=',Auth::user()->id )
            ->select('employees.id as id', 'employees.fname', 'employees.lname', 'employees.mname', 'employees.title', 'official_infos.staff_id')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')            
            ->get()->toArray();
        //dd($historyemployee);
        return view('employee/history', compact('historyemployee'));
    }
    public function history_report(Request $request) {
        $historyemployee = Employee::where('employees.institution_id','=',Auth::user()->id )
            ->select('employees.id as id', 'employees.fname', 'employees.lname', 'employees.mname', 'employees.title', 'official_infos.staff_id')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')            
            ->get()->toArray();
        
        $employeeid = null;
        $historytype = null;
        $academic_data = null;
        $work_experiences = null;
        $certificates = null;
        $referee_infos = null;
        $salary_details = null;
        $Kin_details = null;
        $deaths = null;
        $retirement_historys = null;
        $children_counts = null;
        $contacts = null;
        $residential_contacts = null;
        $lgaa = null;
        $Leave_details = null;
        $Trf_details_out=null;
        $institute=null;
        $fac =null;
        $depa = null;
        $un = null;
        $pr_fac = null;
        $pr_depa = null;
        $pr_un = null;
        $Trf_details_in = null;
        $history_type = $request->historytype;
        if (isset($request->employeename) && ($request->historytype) ) {
            if (in_array("transfer_details", $request->historytype))
            {
                $employeeid = $request->employeename;
                $new_Trf_details = Employee::where('id', '=', $employeeid)->first();
                $Trf_details_out = Transfer::where('nameofstaff', '=', $new_Trf_details->id)->where('institution_id','=',Auth::user()->id)                
                ->get()->toArray();
                $Trf_details_in = Transfer::where('nameofstaff', '=', $new_Trf_details->id)->where('institutionname','=',Auth::user()->id)                
                ->get()->toArray();
                foreach($Trf_details_out as $Trf_detailsd){
                $institute=User::where('id','=',$Trf_detailsd['institutionname'])->first();
                $fac = FacultyDirectorate::where('id',$Trf_detailsd['transferfaculty'])->first();
                $depa = Department::where('id',$Trf_detailsd['transferdepartment'])->first();
                $un = Unit::where('id',$Trf_detailsd['transferunit'])->first();
                $pr_fac = FacultyDirectorate::where('id',$Trf_detailsd['faculty'])->first();
                $pr_depa = Department::where('id',$Trf_detailsd['department'])->first();
                $pr_un = Unit::where('id',$Trf_detailsd['unit'])->first();
                }
                foreach($Trf_details_in as $Trf_detail_in){
                    $instituteIn=User::where('id','=',$Trf_detail_in['institutionname'])->first();
                    $facIn = FacultyDirectorate::where('id',$Trf_detail_in['transferfaculty'])->first();
                    $depaIn = Department::where('id',$Trf_detail_in['transferdepartment'])->first();
                    $unIn = Unit::where('id',$Trf_detail_in['transferunit'])->first();
                    $pr_facIn = FacultyDirectorate::where('id',$Trf_detail_in['faculty'])->first();
                    $pr_depaIn = Department::where('id',$Trf_detail_in['department'])->first();
                    $pr_unIn = Unit::where('id',$Trf_detail_in['unit'])->first();
                    }
            }
            if (in_array("leave_details", $request->historytype))
            {
                // dd($request->historytype);
                $employeeid = $request->employeename;
                $Leave_details = Employee::where('employee_id', '=', $employeeid)
                ->join('leaves', 'employees.id', '=', 'leaves.employee_id')
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')                          
                ->get()->toArray();
                // dd($Leave_details);
            }
            if (in_array("academicqualification", $request->historytype))
            {
                $employeeid = $request->employeename;
                $academic_data = Employee::where('employee_id', '=', $employeeid )
                ->select('academic_qualifications.institutionname','academic_qualifications.academic_upload','academic_qualifications.institutioncategory','academic_qualifications.academicother','academic_qualifications.courseofstudy','academic_qualifications.certificateobtained','academic_qualifications.programmeduration','academic_qualifications.programmedurationenddate','academic_qualifications.acaduration','academic_qualifications.postheldandprojecthandled')   
                ->where('academic_qualifications.deleted_at',null)             
                ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id')               
                ->get()->toArray();
            }
            if (in_array("workexperience", $request->historytype))
            {
                $employeeid = $request->employeename;
                $work_experiences = Employee::where('employee_id', '=', $employeeid )
                ->select('work_experiences.workinstitutionname','designations.title', 'work_experiences.workpostheld', 'work_experiences.workcadre', 'work_experiences.workgradelevel', 'work_experiences.workstep', 'work_experiences.workstartdate','work_experiences.workenddate','work_experiences.workduration')
                ->where('work_experiences.deleted_at',null)  
                ->join('work_experiences', 'employees.id', '=', 'work_experiences.employee_id')
                ->join('designations', 'designations.id', '=', 'work_experiences.workdesignation')
                ->get()->toArray();
            }
            if (in_array("certificates", $request->historytype))
            {
                $employeeid = $request->employeename;
                $certificates = Employee::where('employee_id', '=', $employeeid )
                ->select('certificates.birthcerticate', 'certificates.professionalcertificate', 'certificates.marriagecertificate', 'certificates.awardandhonorarycertificate', 'certificates.othercertificate', 'certificates.deathcertificate')
                ->join('certificates', 'employees.id', '=', 'certificates.employee_id')
                ->get()->toArray();

                foreach($certificates as $certificate){
                    
                if( ( $certificate['birthcerticate'] == NULL)  && ($certificate['professionalcertificate'] == NULL) && ($certificate['marriagecertificate'] == NULL ) && ($certificate['awardandhonorarycertificate'] == NULL ) && ($certificate['othercertificate'] == NULL) && ($certificate['deathcertificate'] == NULL ) ){
                   
                   $certificates = array(); 
                   }
                }
            }
            if (in_array("death", $request->historytype))
            {
                $employeeid = $request->employeename;
                $deaths = Employee::where('id', '=', $employeeid )
                ->get()->toArray();


                foreach($deaths as $death){
                    
                if( ( $death['dateofdeath'] == NULL)  && ($death['causeofdeath'] == NULL)){
                   $deaths = array(); 
                   }
                }
            }
            if (in_array("retirement", $request->historytype))
            {
                $employeeid = $request->employeename;
                $retirement_historys = Employee::where('employee_id', '=', $employeeid )
                ->select('official_infos.expectedretirementdate')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->get()->toArray();
            }
            if (in_array("children_count", $request->historytype))
            {
                $employeeid = $request->employeename;
                $children_counts = Employee::where('id', '=', $employeeid )
                ->get()->toArray();

                foreach($children_counts as $children_count){
                    
                if( ( $children_count['noofchildren'] == NULL)){
                   
                   $children_counts = array(); 
                   }
                }
            }
            if (in_array("contact_details", $request->historytype))
            {
                $employeeid = $request->employeename;
                $contacts = Employee::where('employees.id', '=', $employeeid )
                ->select('employees.fname as emp_name','countries.name as country_name','states.name as states_name','cities.name as city_name', 'employees.phoneno', 'employees.hometown', 'employees.tribe','employees.localgovermentoforigin as lga')
                ->join('countries', 'countries.id', '=', 'employees.country')
                ->join('states', 'states.id', '=', 'employees.state')
                ->join('cities', 'cities.id', '=', 'employees.city')                
                ->get()->toArray();                
                if( empty($contacts) ){
                    //dd("sdsadsad");
                    $contacts = Employee::where('employees.id', '=', $employeeid )
                        ->select('employees.fname as emp_name','countries.name as country_name','states.name as states_name', 'employees.phoneno', 'employees.hometown', 'employees.tribe','employees.localgovermentoforigin as lga')
                        ->join('countries', 'countries.id', '=', 'employees.country')
                        ->join('states', 'states.id', '=', 'employees.state')
                        ->join('local_governments', 'local_governments.id', '=', 'employees.localgovermentoforigin')                
                        ->get()->toArray();

                    foreach ($contacts as $cnt) {
                       // dd($cnt['lga']);  
                        $lgaa = localGovernment::where('id', '=', $cnt['lga'])
                            ->select('local_governments.name as lgas')
                            ->get()->first();
                    }
                }              
                else {
                    foreach ($contacts as $cnt) {
                       // dd($cnt['lga']);  
                        $lgaa = City::where('id', '=', $cnt['lga'])
                            ->select('cities.name as lgas')
                            ->get()->first();
                    }
                }


               
            }
            if (in_array("residential_contact", $request->historytype))
            {
                $employeeid = $request->employeename;
                $residential_contacts = Employee::where('employee_id', '=', $employeeid )
                ->select('residentials.houseno', 'residentials.streetname', 'countries.name as residential_name', 'states.name as residential_state', 'cities.name as residential_city', 'residentials.residentialnationality', 'residentials.residentialstate', 'residentials.localgoverment', 'residentials.citytown', 'residentials.phone_no_1', 'residentials.phone_no_2', 'residentials.email')
                ->join('residentials', 'employees.id', '=', 'residentials.employee_id')
                ->join('countries', 'countries.id', '=', 'residentials.residentialcountry')
                ->join('states', 'states.id', '=', 'residentials.residentialstate')
                ->join('cities', 'cities.id', '=', 'residentials.citytown')
                ->get()->toArray();
            }
            if (in_array("refreedetails", $request->historytype))
            {
                $employeeid = $request->employeename;
                $referee_infos = Employee::where('employee_id', '=', $employeeid )
                ->where('referee_infos.deleted_at',null) 
                ->select('referee_infos.referee_info_fullname', 'referee_infos.referee_info_occupation', 'referee_infos.referee_info_postheld', 'referee_infos.referee_info_address', 'referee_infos.referee_info_phoneno', 'referee_infos.referee_info_email', 'referee_infos.refereeconsentletter')
                ->join('referee_infos', 'employees.id', '=', 'referee_infos.employee_id')
                ->get()->toArray();
            }
            if (in_array("salary_details", $request->historytype))
            {
                $employeeid = $request->employeename;
                $salary_details = Employee::where('employee_id', '=', $employeeid )
                ->select('salary_details.bankname', 'salary_details.accountname', 'salary_details.uploadidcard', 'salary_details.accountnumber', 'salary_details.bvn', 'salary_details.tin')
                ->join('salary_details', 'employees.id', '=', 'salary_details.employee_id')
                ->get()->toArray();
            }
            if (in_array("kin_detail", $request->historytype))
            {
                $employeeid = $request->employeename;
                $Kin_details = Employee::where('employee_id', '=', $employeeid )
                ->select('kin_details.name', 'kin_details.relationship', 'kin_details.kindetailssex', 'kin_details.phoneno', 'kin_details.kinemail', 'kin_details.address', 'kin_details.image')
                ->join('kin_details', 'employees.id', '=', 'kin_details.employee_id')
                ->get()->toArray();
            }
           
          }else{
            
                $employeeid = $request->employeename;
                $new_Trf_details = Employee::where('id', '=', $employeeid)->first();
                $Trf_details_out = Transfer::where('nameofstaff', '=', $new_Trf_details->id)->where('institution_id','=',Auth::user()->id)                
                ->get()->toArray();
                $Trf_details_in = Transfer::where('nameofstaff', '=', $new_Trf_details->id)->where('institutionname','=',Auth::user()->id)                
                ->get()->toArray();
                foreach($Trf_details_out as $Trf_detailsd){
                $institute=User::where('id','=',$Trf_detailsd['institutionname'])->first();
                $fac = FacultyDirectorate::where('id',$Trf_detailsd['transferfaculty'])->first();
                $depa = Department::where('id',$Trf_detailsd['transferdepartment'])->first();
                $un = Unit::where('id',$Trf_detailsd['transferunit'])->first();
                $pr_fac = FacultyDirectorate::where('id',$Trf_detailsd['faculty'])->first();
                $pr_depa = Department::where('id',$Trf_detailsd['department'])->first();
                $pr_un = Unit::where('id',$Trf_detailsd['unit'])->first();
                }
                
                $employeeid = $request->employeename;
                $Leave_details = Employee::where('employee_id', '=', $employeeid )
                ->join('leaves', 'employees.id', '=', 'leaves.employee_id')
                ->join('leavetypes','leaves.leavetype_id','=','leavetypes.id')
                ->select('leaves.*','leavetypes.name')                          
                ->get()->toArray();
                // dd($Leave_details);

                $employeeid = $request->employeename;
                $academic_data = Employee::where('employee_id', '=', $employeeid )
                ->select('academic_qualifications.institutionname','academic_qualifications.academic_upload','academic_qualifications.institutioncategory','academic_qualifications.academicother','academic_qualifications.courseofstudy','academic_qualifications.certificateobtained','academic_qualifications.programmeduration','academic_qualifications.programmedurationenddate','academic_qualifications.acaduration','academic_qualifications.postheldandprojecthandled')  
                ->where('academic_qualifications.deleted_at',null)               
                ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id')               
                ->get()->toArray();

                $employeeid = $request->employeename;
                $work_experiences = Employee::where('employee_id', '=', $employeeid )
                ->select('work_experiences.workinstitutionname','designations.title', 'work_experiences.workpostheld', 'work_experiences.workcadre','work_experiences.workstartdate','work_experiences.workenddate',
                    'work_experiences.workgradelevel', 'work_experiences.workstep', 'work_experiences.workduration')
                ->where('work_experiences.deleted_at',null) 
                ->join('work_experiences', 'employees.id', '=', 'work_experiences.employee_id')
                ->join('designations', 'designations.id', '=', 'work_experiences.workdesignation')
                ->get()->toArray();

                $employeeid = $request->employeename;
                $certificates = Employee::where('employee_id', '=', $employeeid )
                ->select('certificates.birthcerticate', 'certificates.professionalcertificate', 'certificates.marriagecertificate', 'certificates.awardandhonorarycertificate', 'certificates.othercertificate', 'certificates.deathcertificate')
                ->join('certificates', 'employees.id', '=', 'certificates.employee_id')
                ->get()->toArray();

                foreach($certificates as $certificate){
                    
                if( ( $certificate['birthcerticate'] == NULL)  && ($certificate['professionalcertificate'] == NULL) && ($certificate['marriagecertificate'] == NULL ) && ($certificate['awardandhonorarycertificate'] == NULL ) && ($certificate['othercertificate'] == NULL) && ($certificate['deathcertificate'] == NULL ) ){
                   //dd($certificate['birthcerticate']);
                   $certificates = array(); 
                   }
                }

                $employeeid = $request->employeename;
                $deaths = Employee::where('id', '=', $employeeid )
                //->select('deaths.dateofdeath', 'deaths.causeofdeath')
                //->join('deaths', 'employees.id', '=', 'deaths.id')
                ->get()->toArray();

                foreach($deaths as $death){
                    
                if( ( $death['dateofdeath'] == NULL)  && ($death['causeofdeath'] == NULL)){
                   $deaths = array(); 
                   }
                }

                $employeeid = $request->employeename;
                $retirement_historys = Employee::where('employee_id', '=', $employeeid )
                ->select('official_infos.expectedretirementdate')
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->get()->toArray();

                $employeeid = $request->employeename;
                $children_counts = Employee::where('id', '=', $employeeid )
                ->get()->toArray();

                foreach($children_counts as $children_count){
                    
                if( ( $children_count['noofchildren'] == NULL) ){
                   
                   $children_counts = array(); 
                   }
                }

                $employeeid = $request->employeename;
                $contacts = Employee::where('employees.id', '=', $employeeid )
                ->select('employees.fname as emp_name','countries.name as country_name','states.name as states_name','cities.name as city_name', 'employees.phoneno', 'employees.hometown', 'employees.tribe','employees.localgovermentoforigin as lga')
                ->join('countries', 'countries.id', '=', 'employees.country')
                ->join('states', 'states.id', '=', 'employees.state')
                ->join('cities', 'cities.id', '=', 'employees.city')                
                ->get()->toArray();
                $lgaa = null;
                if( empty($contacts) ){
                    //dd("sdsadsad");
                    $contacts = Employee::where('employees.id', '=', $employeeid )
                        ->select('employees.fname as emp_name','countries.name as country_name','states.name as states_name', 'employees.phoneno', 'employees.hometown', 'employees.tribe','employees.localgovermentoforigin as lga')
                        ->join('countries', 'countries.id', '=', 'employees.country')
                        ->join('states', 'states.id', '=', 'employees.state')
                        ->join('local_governments', 'local_governments.id', '=', 'employees.localgovermentoforigin')                
                        ->get()->toArray();

                    foreach ($contacts as $cnt) {
                       // dd($cnt['lga']);  
                        $lgaa = localGovernment::where('id', '=', $cnt['lga'])
                            ->select('local_governments.name as lgas')
                            ->get()->first();
                    }
                }              
                else {
                    foreach ($contacts as $cnt) {
                       // dd($cnt['lga']);  
                        $lgaa = City::where('id', '=', $cnt['lga'])
                            ->select('cities.name as lgas')
                            ->get()->first();
                    }
                }
                

                $employeeid = $request->employeename;
                $residential_contacts = Employee::where('employee_id', '=', $employeeid )
                ->select('residentials.houseno', 'residentials.streetname', 'countries.name as residential_name', 'states.name as residential_state', 'cities.name as residential_city', 'residentials.residentialnationality', 'residentials.residentialstate', 'residentials.localgoverment', 'residentials.citytown', 'residentials.phone_no_1', 'residentials.phone_no_2', 'residentials.email')
                ->join('residentials', 'employees.id', '=', 'residentials.employee_id')
                ->join('countries', 'countries.id', '=', 'residentials.residentialcountry')
                ->join('states', 'states.id', '=', 'residentials.residentialstate')
                ->join('cities', 'cities.id', '=', 'residentials.citytown')
                ->get()->toArray();

                $employeeid = $request->employeename;
                $referee_infos = Employee::where('employee_id', '=', $employeeid )
                ->where('referee_infos.deleted_at',null) 
                ->select('referee_infos.referee_info_fullname', 'referee_infos.referee_info_occupation', 'referee_infos.referee_info_postheld', 'referee_infos.referee_info_address', 'referee_infos.referee_info_phoneno', 'referee_infos.referee_info_email', 'referee_infos.refereeconsentletter')
                ->join('referee_infos', 'employees.id', '=', 'referee_infos.employee_id')
                ->get()->toArray();

                $employeeid = $request->employeename;
                $salary_details = Employee::where('employee_id', '=', $employeeid )
                ->select('salary_details.bankname', 'salary_details.accountname', 'salary_details.uploadidcard', 'salary_details.accountnumber', 'salary_details.bvn', 'salary_details.tin')
                ->join('salary_details', 'employees.id', '=', 'salary_details.employee_id')
                ->get()->toArray();

                $employeeid = $request->employeename;
                $Kin_details = Employee::where('employee_id', '=', $employeeid )
                ->select('kin_details.name', 'kin_details.relationship', 'kin_details.kindetailssex', 'kin_details.phoneno', 'kin_details.kinemail', 'kin_details.address', 'kin_details.image')
                ->join('kin_details', 'employees.id', '=', 'kin_details.employee_id')
                ->get()->toArray();
          }
            // dd($academic_data);
          //dd($certificates);
        return view('employee/history', compact('Trf_details_in','institute','fac','depa','un','pr_fac','pr_depa','pr_un','Trf_details_out','Leave_details','historyemployee', 'academic_data', 'work_experiences', 'employeeid', 'certificates','referee_infos', 'salary_details', 'Kin_details', 'deaths', 'retirement_historys', 'children_counts', 'contacts','residential_contacts', 'history_type','lgaa'));
    }    
    /* Employe History end */

    /* Employe Filter start */
    public function filter() { 
        $facultyfilter = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        //$departments = Department::where('user_id','=',Auth::user()->id)->get();
        //$units = Unit::where('user_id','=',Auth::user()->id)->get();           
        /*$employee_name = Employee::where('employees.institution_id','=',Auth::user()->id )
            ->select('employees.id as id', 'employees.fname', 'employees.lname', 'employees.mname', 'employees.title', 'official_infos.staff_id')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')            
            ->get()->toArray();  */
        //dd($employee);
        
        return view('employee/filter', compact('facultyfilter'/*,'departments','units','employee_name'*/));
    }
    public function data(Request $request) {
        //$facultyfilter = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $facultyfilter = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $departments = Department::where('user_id','=',Auth::user()->id)->get();
        $units = Unit::where('user_id','=',Auth::user()->id)->get();           
        $employee_name = Employee::where('employees.institution_id','=',Auth::user()->id )
            ->select('employees.id as id', 'employees.fname', 'employees.lname', 'employees.mname', 'employees.title', 'official_infos.staff_id')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')            
            ->get()->toArray();
        // dd($employee_name);
        /*$employee_data = $request->employee;
        $faculty_data = $request->faculty;
        $department_data = $request->department;
        $unit_data = $request->unit;*/
        if ( isset($request->faculty) ) {
            $faculty_data = $request->faculty;
            $faculty = $request->faculty;
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.directorate','=',$faculty)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else{
            $faculty_data = '';
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }

        //dd($facultydata);
        if ( isset($request->department) ) {
            $department_data = $request->department;
            $department = $request->department;
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.department','=',$department)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $department_data = '';
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->pluck('id')->toArray();
        }
        if ( isset($request->unit) ) {
            $unit_data = $request->unit;
            $unit = $request->unit;
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.unit','=',$unit)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $unit_data = '';
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }
        if ( isset($request->employee) ) {
            $employee_data = $request->employee;
            $employee = $request->employee;
            $employeedata = Employee::where('id','=',$employee )                        
                ->pluck('id')->toArray();
        }
        else {
            $employee_data = '';
            $employeedata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->pluck('id')->toArray();
        }
        
        $data = array_intersect($facultydata,$departmentdata,$employeedata,$unitdata);
        $data = array_values($data);
        $collection = collect(new Employee);
        foreach ($data as $key => $value) {           
            $emp = Employee::where('id', $value)->first();
            $collection->put($key, $emp);
        }

        $data = $collection;
        $filtered_id = array();
        foreach( $data as $filteredid ) {            
            if($filteredid->country == 160) {
                $filtered_id[] = Employee::where('employees.id', '=', $filteredid->id )
                ->select('local_governments.name as lgas')
                ->join('local_governments', 'local_governments.id', '=', 'employees.localgovermentoforigin')               
                ->get()->first();
            }
            else {
                $filtered_id[] = Employee::where('employees.id', '=', $filteredid->id )
                ->select('cities.name as lgas')
                ->join('cities', 'cities.id', '=', 'employees.localgovermentoforigin')             
                ->get()->first();
            }
        }
        foreach($filtered_id as $keys => $val) {            
            if($val != null) {
                $data[$keys]['lga'] = $val['lgas'];
            }
            else{
                $data[$keys]['lga'] = '';
            }
        }
        if ( isset($request->filtecontnet) ) {
            $filtecontnet = $request->filtecontnet;   
            $selectfiltecontnet = $request->filtecontnet;
        }

        else {
            $selectfiltecontnet = array();
            //$filtecontnet = Null;
            $filtecontnet = [ 'firstname', 'middlename', 'lastname', 'maidenname', 'gender', 'maritalstatus', 'religion', 'disability', 'localgovernmentoforigin', 'localgovernmentoforigin', 'localgovernmentoforigin', 'localgovernmentoforigin', 'designation', 'cadre', 'gradelevel', 'step', 'age', 'joindate','serviceyears', 'retirmentdate', 'spouse', 'certificatesobtained', 'accountname', 'bankname', 'bvn', 'tin', 'accountnumber', 'nextofkin', ];
        }
        // dd($filtecontnet);
        return view('employee/filter', compact('data','filtecontnet','employee_data', 'facultyfilter'/*, 'departments', 'units', 'employee_name'*/, 'faculty_data', 'department_data', 'unit_data','selectfiltecontnet'));

    }
    /* Employe Filter end */

    // Data Expoer
    public function dataExport() {

        if ( isset($_POST['faculty_id'] ) && $_POST['faculty_id'] != '' )  {
            $faculty = $_POST['faculty_id'];
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.directorate','=',$faculty)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        
             //die;
        else{
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }
        //dd($facultydata);
        if ( isset($_POST['department_id']) && $_POST['department_id'] != '' ) {
            $department = $_POST['department_id'];
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.department','=',$department)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }
        if ( isset($_POST['unit_id']) && $_POST['unit_id'] != '' ) {
            $unit = $request->unit;
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.unit','=',$unit)                                        
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }
        if ( isset($_POST['employee']) && $_POST['employee'] != '' ) {
            $employee = $request->employee;
            $employeedata = Employee::where('id','=',$employee )                        
                ->pluck('id')->toArray();
        }
        else {
            $employeedata = Employee::where('employees.institution_id','=',Auth::user()->id )                        
                ->pluck('id')->toArray();
        }
        
        $data = array_intersect($facultydata,$departmentdata,$employeedata,$unitdata);
        $collection = collect(new Employee);
        foreach ($data as $key => $value) {           
            $emp = Employee::where('id', $value)->first();
            $collection->put($key, $emp);
        }
        $data = $collection;
        //echo json_encode($departmentdata);
        echo json_encode($data);
        die; 
        
    }

    public function graph() { 
        $facultyfilter = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $departments = Department::where('user_id','=',Auth::user()->id)->get();
        $units = Unit::where('user_id','=',Auth::user()->id)->get();           
        $employee_name = Employee::where('employees.institution_id','=',Auth::user()->id )
            ->select('employees.id as id', 'employees.fname', 'employees.lname', 'employees.mname', 'employees.title', 'official_infos.staff_id')
            ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')            
            ->get()->toArray();  
        //dd($employee);
        
        return view('employee/graph', compact('facultyfilter','departments','units','employee_name'));
    }

    public function graphreport(Request $request) {
        $facultyfilter = FacultyDirectorate::where('user_id','=',Auth::user()->id)->get();
        $departments = Department::where('user_id','=',Auth::user()->id)->get();
        $units = Unit::where('user_id','=',Auth::user()->id)->get();
        $faculty_data = $request->faculty;
        $department_data = $request->department;
        $unit_data = $request->unit;
        if ( isset($request->faculty) ) {
            $faculty = $request->faculty;
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.directorate','=',$faculty)
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $facultydata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->pluck('id')->toArray();
        }
        if ( isset($request->department) ) {
            $department = $request->department;
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.department','=',$department)
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $departmentdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->pluck('id')->toArray();
        }
        if ( isset($request->unit) ) {
            $unit = $request->unit;
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->where('official_infos.unit','=',$unit)
                ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                ->pluck('employee_id')->toArray();
        }
        else {
            $unitdata = Employee::where('employees.institution_id','=',Auth::user()->id )
                ->pluck('id')->toArray();
        }
              
        $data = array_intersect($facultydata,$departmentdata,$unitdata);
        $collection = collect(new Employee);
        foreach ($data as $key => $value) {
            $emp = Employee::where('id', $value)->first();
            $collection->put($key, $emp);
        }
        $data = $collection;
        
        $datasss = array_intersect($facultydata,$departmentdata,$unitdata);       
        if(count($datasss) > 0) {
            foreach ($datasss as $valuess) {  
                $malemarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','male')
                    ->where('employees.maritalstatus','=','married')
                    ->select('*')
                    ->get()->count();
                $maleunmarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','male')
                    ->where('employees.maritalstatus','=','unmarried')
                    ->select('*')
                    ->get()->count();
                $malesingle[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','male')
                    ->where('employees.maritalstatus','=','single')
                    ->select('*')
                    ->get()->count();
                $maleother[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','male')
                    ->where('employees.maritalstatus','=','other')
                    ->select('*')
                    ->get()->count();            
                $malecount = [array_sum($malesingle), array_sum($malemarried), array_sum($maleunmarried), array_sum($maleother)];

                $femalemarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','female')
                    ->where('employees.maritalstatus','=','married')
                    ->select('*')
                    ->get()->count();
                $femaleunmarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','female')
                    ->where('employees.maritalstatus','=','unmarried')
                    ->select('*')
                    ->get()->count();
                $femalesingle[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','female')
                    ->where('employees.maritalstatus','=','single')
                    ->select('*')
                    ->get()->count();
                $femaleother[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','female')
                    ->where('employees.maritalstatus','=','other')
                    ->select('*')
                    ->get()->count();            
                $femalecount = [array_sum($femalesingle), array_sum($femalemarried), array_sum($femaleunmarried), array_sum($femaleother)];

                $othermarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','other')
                    ->where('employees.maritalstatus','=','married')
                    ->select('*')
                    ->get()->count();
                $otherunmarried[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','other')
                    ->where('employees.maritalstatus','=','unmarried')
                    ->select('*')
                    ->get()->count();
                $othersingle[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','other')
                    ->where('employees.maritalstatus','=','single')
                    ->select('*')
                    ->get()->count();
                $otherother[] = DB::table('employees')
                    ->where('id', $valuess)
                    ->where('employees.sex','=','other')
                    ->where('employees.maritalstatus','=','other')
                    ->select('*')
                    ->get()->count();            
                $othercount = [array_sum($othersingle), array_sum($othermarried), array_sum($otherunmarried), array_sum($otherother)];
                
                $religion[] = DB::table('employees')
                    ->where('id',$valuess)
                    ->pluck('religion')->first();

                $certiobtained[] = DB::table('employees')
                    ->where('academic_qualifications.employee_id',$valuess ) 
                    ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id')
                    ->pluck('certificateobtained')->all();
                    /*dd($certiobtained);*/
                $gradelevel[] = DB::table('employees')
                    ->where('employees.id',$valuess ) 
                    ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                    ->pluck('gradelevel')->first();
            }  
            //dd($gradelevel);
            $religion = array_values(array_unique($religion));
            $gradelevel = array_values(array_unique($gradelevel));
            //dd($gradelevel);
            foreach($religion as $religions) {
                //$religionname[] = $religions;           
                $femalereligionname = "religionfe{$religions}";
                $$femalereligionname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','female')
                    ->where('employees.religion','=',$religions)                    
                    ->select('*')
                    ->get()->count();
                $femalereligioncount[] = $$femalereligionname;

                $malereligionname = "religionfe{$religions}";
                $$malereligionname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','male')
                    ->where('employees.religion','=',$religions)                    
                    ->select('*')
                    ->get()->count();
                $malereligioncount[] = $$malereligionname;

                $otherreligionname = "religionfe{$religions}";
                $$otherreligionname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','other')
                    ->where('employees.religion','=',$religions)                    
                    ->select('*')
                    ->get()->count();
                $otherreligioncount[] = $$otherreligionname;
            }
            /* Employee Count V/S Designation V/S Gender */ 
            $designation = DB::table('designations')
                    ->where('designations.user_id','=',Auth::user()->id )                              
                    ->select('designations.title','designations.id as desiid')->get();
            foreach($designation as $designations) {
                $designationname[] = $designations->title;
                $designationid[] = $designations->desiid;            
                    $femalelistname = "designationfe{$designations->title}";
                    $$femalelistname = DB::table('employees')
                        ->whereIn('employees.id', $datasss)
                        ->where('employees.sex','=','female')
                        ->where('official_infos.designation','=',$designations->desiid)
                        ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                        ->select('*')
                        ->get()->count();
                    $femaledesignationcount[] = $$femalelistname;
                    $malelistname = "designationmale{$designations->title}";
                    $$malelistname = DB::table('employees')
                        ->whereIn('employees.id', $datasss)
                        ->where('employees.sex','=','male')
                        ->where('official_infos.designation','=',$designations->desiid)
                        ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                        ->select('*')
                        ->get()->count();
                    $maledesignationcount[] = $$malelistname;
                    $otherlistname = "designationother{$designations->title}";
                    $$otherlistname = DB::table('employees')
                        ->whereIn('employees.id', $datasss)
                        ->where('employees.sex','=','other')
                        ->where('official_infos.designation','=',$designations->desiid)
                        ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                        ->select('*')
                        ->get()->count();
                    $otherdesignationcount[] = $$otherlistname;
            }
            foreach($religion as $relig) {            
                foreach($designation as $desi) {                
                    $desiname = "desi{$desi->title}";
                    $$desiname = DB::table('employees')
                        ->whereIn('employees.id', $datasss)
                        ->where('employees.religion','=',$relig)
                        ->where('official_infos.designation','=',$desi->desiid)
                        ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id')
                        ->select('*')
                        ->get()->count();
                    $religdesignationcount[$relig][] = $$desiname;
                }
            }
            //dd($certiobtained);
            foreach($certiobtained as $certi){
               foreach ($certi as $certis){
                    $certies[] = $certis;
               }          
            }
            //dd($certies);

            $certiobtained = array_values(array_unique($certies));
            foreach($certiobtained as $certiobtain) {
                //$religionname[] = $religions;           
                $femalecertiobtainname = "certiobtainfe{$certiobtain}";
                $$femalecertiobtainname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','female')
                    ->where('academic_qualifications.certificateobtained','=',$certiobtain)  
                    ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id') 
                    ->select('*')
                    ->get()->count();
                $femalecertiobtaincount[] = $$femalecertiobtainname;

                $malecertiobtainname = "certiobtainfe{$certiobtain}";
                $$malecertiobtainname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','male')
                    ->where('academic_qualifications.certificateobtained','=',$certiobtain)  
                    ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id')
                    ->select('*')
                    ->get()->count();
                $malecertiobtaincount[] = $$malecertiobtainname;

                $othercertiobtainname = "certiobtainfe{$certiobtain}";
                $$othercertiobtainname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','other')
                    ->where('academic_qualifications.certificateobtained','=',$certiobtain)  
                    ->join('academic_qualifications', 'employees.id', '=', 'academic_qualifications.employee_id')
                    ->select('*')
                    ->get()->count();
                $othercertiobtaincount[] = $$othercertiobtainname;
            }
            $gradelevel = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,'Other');
            foreach($gradelevel as $gradelevels) {
                $femalegradelevelnname = "gradelevelfe{$gradelevels}";
                $$femalegradelevelnname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','female')
                    ->where('official_infos.gradelevel','=',$gradelevels)  
                    ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id') 
                    ->select('*')
                    ->get()->count();
                $femalegradelevelcount[] = $$femalegradelevelnname;

                $malegradelevelnname = "gradelevelmale{$gradelevels}";
                $$malegradelevelnname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','male')
                    ->where('official_infos.gradelevel','=',$gradelevels)  
                    ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id') 
                    ->select('*')
                    ->get()->count();
                $malegradelevelcount[] = $$malegradelevelnname;

                $othergradelevelnname = "gradelevelother{$gradelevels}";
                $$othergradelevelnname = DB::table('employees')
                    ->whereIn('employees.id', $datasss)
                    ->where('employees.sex','=','other')
                    ->where('official_infos.gradelevel','=',$gradelevels)  
                    ->join('official_infos', 'employees.id', '=', 'official_infos.employee_id') 
                    ->select('*')
                    ->get()->count();
                $othergradelevelcount[] = $$othergradelevelnname;  
                
            }
            //dd($malegradelevelcount);
        }
        else{
            $malecount = 0;
            $femalecount = 0;
            $othercount = 0;
            $designationname = NULL;
            $femaledesignationcount = 0;
            $maledesignationcount = 0;
            $otherdesignationcount = 0;
            $religion = NULL;
            $femalereligioncount = 0;
            $malereligioncount = 0;
            $otherreligioncount = 0;
            $religdesignationcount = 0;
            $certiobtained = NULL;
            $femalecertiobtaincount = 0;
            $malecertiobtaincount = 0;
            $othercertiobtaincount = 0;
            $femalegradelevelcount = 0;
            $gradelevel = NULL;
            $malegradelevelcount = 0;
            $othergradelevelcount = 0;
        }
        return view('employee/graph', compact('data', 'facultyfilter', 'departments', 'units', 'faculty_data', 'department_data', 'unit_data','malecount','femalecount','othercount','designationname','femaledesignationcount','maledesignationcount','otherdesignationcount','religion','femalereligioncount','malereligioncount','otherreligioncount','religdesignationcount','certiobtained','femalecertiobtaincount','malecertiobtaincount','othercertiobtaincount','gradelevel','femalegradelevelcount','malegradelevelcount','othergradelevelcount'));
    }

    public function getDepartment(Request $request)
    {
        if($request->directorate_id != '') {
            $data['departmentname'] = Department::where("faculty_id", $request->directorate_id)
            ->get();
        }
        return response()->json($data);
    }
    public function getUnit(Request $request)
    {
        if($request->department_id != '') {
            $data['unit'] = Unit::where("department_id", $request->department_id)
                ->get();
            $data['desi'] = Designation::where("department_id", $request->department_id)
                ->get();
        }
        return response()->json($data);
    }
    public function getemployeelist(Request $request)
    {
        if($request->unit_id != '') {
            $data['employeename'] = OfficialInfo::where("unit", $request->unit_id)  
                ->where("employees.deleted_at", null)         
                ->join('employees', 'official_infos.employee_id', '=', 'employees.id') 
                ->get();
        }
        return response()->json($data);
    }
    public function pdf($id) {

        $employee = Employee::findOrFail($id);
        $stfid = $employee->official_information->staff_id;
        $phone = $employee->phoneno;
        $empname = ucwords($employee->fname." ".$employee->mname." ".$employee->lname);
        $empdepartment = ucwords($employee->official_information->departments_dt->departmentname);
        $joindate = $employee->official_information->dateofemployment->format('d/m/Y');
        $designation = isset($employee->official_information->designations->title) ? $employee->official_information->designations->title : '';
        $institution_detail =  User::findOrFail($employee->institution_id);
        $cntname = '';
        $statename = '';
        if(isset($employee->residentails->residentialcountry)) {
            $countryname = Country::findOrFail($employee->residentails->residentialcountry);
            $cntname = $countryname->name;
        }
        
        
        if(isset($employee->residentails->residentialstate) && isset($countryname->id )) {
            $state = State::where('id','=',$employee->residentails->residentialstate)->where('country_id','=',$countryname->id)->first();
            if($state != Null) {
                $statename = $state->name;
            }
        }
        
        //$empaddress = $employee->residentails->houseno.", ".$employee->residentails->streetname.", ".$employee->residentails->streetname.", ".$countryname->name.", ".$state->name;
        $empaddress = $employee->residentails->houseno;
        if($employee->residentails->streetname != '') {
            $empaddress .= ", ".$employee->residentails->streetname;
        }
        if($statename != '') {
            $empaddress .= ", \n".$statename;
        }
        if($cntname != '') {
            $empaddress .= ", ".$cntname;
        }

        if(isset($employee->profile_image) ){
            $profile_image = $employee->profile_image;
        }
        if(isset($employee->qrcode) ){
            $qrcode_image = $employee->qrcode;
        }
        
        $pdf = new Fpdi();        
            
        //$fileContent = file_get_contents(public_path().'/public/files/blankidcard.pdf','rb');
        $fileContent = file_get_contents(public_path().'/public/files/idcard.pdf','rb');
        //$fileContent = file_get_contents(public_path().'/public/files/id-card-blank.pdf','rb');
        
        $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();    
            $tplpageno = $pdf->importPage($pageNo);        

            //$pdf->useTemplate($tplpageno, ['adjustPageSize' => true]);
            $pdf->useTemplate($tplpageno, $x = null, $y = null, $w = 100, $h = 161, $adjustPageSize = true );
            
            if ($pageNo == 1){
                $pdf->SetFont('Courier');
                $pdf->setFontSize(13);
                $pdf->SetTextColor(0,0,0);
                         
                $pdf->Image(public_path().'/public/images/'.$institution_detail->instiimage, 37, 0, 25);

                $pdf->SetXY(2, 25);
                $pdf->setFontSize(12);
                $pdf->MultiCell(96,4,$institution_detail->institutionmotto,0,'C',false);   

                if (isset($employee->profile_image) && ($employee->profile_image != '') ) {
                    $pdf->Image(public_path().'/public/employee/'.$profile_image, 35, 35, 30,30.5);
                }
                //$pdf->setFontSize(15);
                $pdf->SetFont('Courier', 'B', 21);
                $pdf->SetTextColor(36, 53, 84);
               
                $pdf->SetXY(2, 71);
                //$pdf->Cell(96,4,$empname,0,0,'C');
                $pdf->MultiCell(96,6,$empname,0,'C',false);  

                $pdf->SetFont('Courier', '', 19);
                $pdf->SetTextColor(217, 156, 69);
                $pdf->SetXY(2, 85);
                $pdf->Cell(96,4,$empdepartment,0,0,'C');

                $pdf->SetTextColor(0,0,0);
                $pdf->setFontSize(13);

                $pdf->SetXY(33, 92.5);
                $pdf->Cell(60,4,$stfid,0,'L');

                $pdf->SetXY(33, 101.5);
                $pdf->Cell(60,4,$phone,0,'L');

                $pdf->SetXY(47, 112.5);
                $pdf->Cell(52,4,$joindate,0,'L');

                $pdf->SetXY(47, 121);
                //$pdf->Cell(23,3,$designation,0,1,'L');
                $pdf->MultiCell(52,6,$designation,0,'L',false);

                if(isset($qrcode_image) ){
                   $pdf->Image(public_path().'/qrcodes/'.$qrcode_image, 9, 135, 20);
                }
            }
            if ($pageNo == 2){
                $pdf->SetFont('Courier', 'B', 22);
                $pdf->SetTextColor(36, 53, 84);
                $pdf->setFontSize(16);

                // $pdf->SetXY(2, 30);
                // $pdf->Cell(96,4,$institution_detail->institutionname,0,0,'C');

                $pdf->SetXY(2, 30);
                $pdf->MultiCell(96,6,$institution_detail->institutionname,0,'C', false);

           

                $pdf->SetFont('Courier', '', 13);
                $pdf->SetTextColor(0,0,0);

                $pdf->SetXY(4, 54);
                $pdf->Cell(94,4,'Veronica Robel',0,'L');

                $pdf->SetXY(4, 73);
                $pdf->MultiCell(94,6,$empaddress,0,'L',false);

                $pdf->SetXY(4, 108);
                $pdf->Cell(94,4,$employee->employeeemail,0,'L');

                $pdf->SetXY(4, 130);
                $pdf->Cell(94,4,$employee->phoneno,0,'L');
            }
        }
        // Output the new PDF
        $pdf->Output();
    }

    public function getDivision(Request $request) {
        if($request->directorate_id != '') {
            $data['departmentname'] = Division::where("faculty_id", $request->directorate_id)
            ->get();
        }
        return response()->json($data);
    }

    public function getUnitNonAcademic(Request $request) {
        if($request->department_id != '') {
            $data['unit'] = NonAcademicUnit::where("department_id", $request->department_id)
                ->get();
            $data['desi'] = NonAcademicsDesignation::where("department_id", $request->department_id)
                ->get();
        }
        return response()->json($data);
    }

    
}
