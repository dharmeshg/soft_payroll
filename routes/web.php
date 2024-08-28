<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\Institutioncontroller;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NonAcademicDepartmentController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TransferClassController;
use App\Http\Controllers\TransferCategoryController;
use App\Http\Controllers\TransferTypeController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransferReasonController;
use App\Http\Controllers\ProcessTransferController;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\AuthorizeTransferController;
use App\Http\Controllers\ApproveTransferController;
use App\Http\Controllers\LeavetypeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AssignLeaveController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\InstituteRolesController;
use App\Http\Controllers\InstitutePermissionController;
use App\Http\Controllers\InstiRolePermissonController;
use App\Http\Controllers\HOULeaveController;
use App\Http\Controllers\DestinationApproveController;
use App\Http\Controllers\TansferOtherController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\NonAcademicUnitController;
use App\Http\Controllers\NonAcademicDesignationController;









/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*Route::get('/', function () {
    return redirect('admin/home');
    })->middleware('auth');
Route::get('/home', function () {
    return redirect('admin/home');
    })->middleware('is_admin');*/

/*});*/

// Auth::routes(['register' => false]);
Route::get('/', function () {
    if (in_array(Auth::user()->is_school, [1])) {
        return redirect('institute/home');
    } else {
        return redirect('admin/home');
    }
})->middleware('auth');
Route::get('/home', function () {
    if (in_array(Auth::user()->is_school, [1])) {
        return redirect('institute/home');
    } else {
        return redirect('admin/home');
    }
})->middleware('auth');
Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('is_admin');

    //users
    Route::get('users/edit', [UserController::class, 'index'])->name('index');
    Route::post('users/edit', [UserController::class, 'store'])->name('index');
    Route::get('users/logout', [UserController::class, 'userLogout'])->name('user.logout');
    Route::get('users/changepasswordget', [UserController::class, 'changepasswordget'])->name('changepasswordget');
    Route::post('users/changepassword', [UserController::class, 'changePasswordPost'])->name('changePasswordPost');



    //institution super admin
    Route::get('institution', [Institutioncontroller::class, 'index'])->name('institution.list')->middleware('is_admin', 'auth');
    Route::get('institution/add', [Institutioncontroller::class, 'add'])->name('add.institution')->middleware('is_admin', 'auth');
    Route::post('institution/store', [Institutioncontroller::class, 'store'])->name('institution.store')->middleware('is_admin', 'auth');
    Route::get('institution/edit/{id}', [Institutioncontroller::class, 'edit'])->name('institution.edit')->middleware('is_admin', 'auth');
    Route::post('institution/update/{id}', [Institutioncontroller::class, 'update'])->name('institution.update')->middleware('is_admin', 'auth');
    Route::get('institution/delete{id}', [Institutioncontroller::class, 'delete'])->name('institution.delete')->middleware('is_admin', 'auth');
    Route::post('institution/status-update', [Institutioncontroller::class, 'statusUpdate'])->name('statusupdate')->middleware('is_admin', 'auth');

    // school super admin
    Route::get('school', [SchoolController::class, 'index'])->name('school.list')->middleware('is_admin', 'auth');
    Route::get('school/add', [SchoolController::class, 'add'])->name('add.school')->middleware('is_admin', 'auth');
    Route::post('school.store', [SchoolController::class, 'store'])->name('school.store')->middleware('is_admin', 'auth');
    Route::get('school/edit/{id}', [SchoolController::class, 'edit'])->name('school.edit')->middleware('is_admin', 'auth');
    Route::post('school/update/{id}', [SchoolController::class, 'update'])->name('school.update')->middleware('is_admin', 'auth');
    Route::get('school/delete/{id}', [SchoolController::class, 'delete'])->name('school.delete')->middleware('is_admin', 'auth');
    Route::post('school/status-update', [SchoolController::class, 'statusUpdate'])->name('StatusUpdate1')->middleware('is_admin', 'auth');
});
Route::namespace('Auth')->group(function () {
    //forgetpassword
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});

// Institute dashboard
Route::get('institute/home', [App\Http\Controllers\InstituteController::class, 'index'])->name('home.institute');
Route::get('institute/list', [App\Http\Controllers\InstituteController::class, 'list'])->name('list.institute');
Route::post('institute/saveToDoData', [App\Http\Controllers\InstituteController::class, 'saveToDoData'])->name('saveToDoData.institute');
Route::get('institute/removetodo', [App\Http\Controllers\InstituteController::class, 'removetodo'])->name('removetodo.institute');
Route::get('institute/get-to-do-list', [App\Http\Controllers\InstituteController::class, 'getToDoList'])->name('getToDoList.institute');
Route::get('institute/read-all-notification', [App\Http\Controllers\InstituteController::class, 'readAllNotification'])->name('insti-read-all-notification');
Route::get('institute/viewprofile', [App\Http\Controllers\InstituteController::class, 'profile'])->name('institute.profile');
Route::post('institute/viewprofile', [App\Http\Controllers\InstituteController::class, 'updateprofile'])->name('institute.profile.update');

Route::get('facultydirectorate/add', [App\Http\Controllers\FacultyDirectorateController::class, 'add'])->name('add.facultydirectorate')->middleware('auth');
Route::get('facultydirectorate', [App\Http\Controllers\FacultyDirectorateController::class, 'index'])->name('facultydirectorate.list')->middleware('auth');
Route::post('facultydirectorate/store', [App\Http\Controllers\FacultyDirectorateController::class, 'store'])->name('facultydirectorate.store')->middleware('auth');
Route::get('facultydirectorate/edit/{id}', [App\Http\Controllers\FacultyDirectorateController::class, 'edit'])->name('facultydirectorate.edit')->middleware('auth');
Route::post('facultydirectorate/update/{id}', [App\Http\Controllers\FacultyDirectorateController::class, 'update'])->name('facultydirectorate.update')->middleware('auth');
Route::get('facultydirectorate/delete/{id}', [App\Http\Controllers\FacultyDirectorateController::class, 'delete'])->name('facultydirectorate.delete')->middleware('auth');

//

// unit
Route::get('unit', [UnitController::class, 'index'])->name('unit.list')->middleware('auth');
Route::get('unit/add', [UnitController::class, 'add'])->name('add.unit')->middleware('auth');
Route::post('unit/store', [UnitController::class, 'store'])->name('unit.store')->middleware('auth');
Route::get('unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit')->middleware('auth');
Route::post('unit/update/{id}', [UnitController::class, 'update'])->name('unit.update')->middleware('auth');
Route::get('unit/delete/{id}', [UnitController::class, 'delete'])->name('unit.delete')->middleware('auth');

Route::get('non-academic-unit', [NonAcademicUnitController::class, 'index'])->name('non_academic_unit.list')->middleware('auth');
Route::get('non-academic-unit/edit/{id}', [NonAcademicUnitController::class, 'edit'])->name('non_academic_unit.edit')->middleware('auth');
Route::get('non-academic-unit/delete/{id}', [NonAcademicUnitController::class, 'delete'])->name('non_academic_unit.delete')->middleware('auth');




// Designation
Route::get('designation', [DesignationController::class, 'index'])->name('designation.list')->middleware('auth');
Route::get('designation/add', [DesignationController::class, 'add'])->name('add.designation')->middleware('auth');
Route::post('designation/store', [DesignationController::class, 'store'])->name('designation.store')->middleware('auth');
Route::get('designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit')->middleware('auth');
Route::post('designation/update/{id}', [DesignationController::class, 'update'])->name('designation.update')->middleware('auth');
Route::get('designation/delete/{id}', [DesignationController::class, 'delete'])->name('designation.delete')->middleware('auth');
Route::post('designation/status-update', [DesignationController::class, 'statusUpdate'])->name('designation.statusupdate')->middleware('auth');
Route::post('department/designation', [DesignationController::class, 'getDepartment'])->name('depart')->middleware('auth');

// Designation Non Academic
Route::get('non-academic-designation', [NonAcademicDesignationController::class, 'index'])->name('non_academic_designation.list')->middleware('auth');


// Department
Route::get('department', [DepartmentController::class, 'index'])->name('department.list')->middleware('auth');
Route::get('department/add', [DepartmentController::class, 'add'])->name('add.department')->middleware('auth');
Route::post('department/store', [DepartmentController::class, 'store'])->name('department.store')->middleware('auth');
Route::get('department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit')->middleware('auth');
Route::post('department/update/{id}', [DepartmentController::class, 'update'])->name('department.update')->middleware('auth');
Route::get('department/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete')->middleware('auth');
Route::post('department/status-update', [DepartmentController::class, 'statusUpdate'])->name('department.statusupdate')->middleware('auth');
Route::post('unit/department', [UnitController::class, 'getDepartment'])->name('getDepartment')->middleware('auth');
Route::post('non-academic-unit/department', [UnitController::class, 'getDivision'])->name('getDivision')->middleware('auth');

//Non Academic
Route::post('non-academic-department/add', [NonAcademicDepartmentController::class, 'store'])->name('non_academic_department.store')->middleware('auth');
Route::get('non-academic-department', [NonAcademicDepartmentController::class, 'index'])->name('non_academic_department.list')->middleware('auth');
Route::post('non-academic-department/update/{id}', [NonAcademicDepartmentController::class, 'update'])->name('non_academic_department.update')->middleware('auth');
Route::get('non-academic-department/delete/{id}', [NonAcademicDepartmentController::class, 'delete'])->name('non_academic_department.delete')->middleware('auth');
Route::get('non-academic-department/edit/{id}', [NonAcademicDepartmentController::class, 'edit'])->name('non_academic_department.edit')->middleware('auth');
Route::post('non-academic-department/status-update', [NonAcademicDepartmentController::class, 'statusUpdate'])->name('non_academic_department.statusupdate')->middleware('auth');

// Division
Route::get('division', [DivisionController::class, 'index'])->name('division.list')->middleware('auth');
Route::get('division/add', [DivisionController::class, 'add'])->name('add.division')->middleware('auth');
Route::post('division/store', [DivisionController::class, 'store'])->name('division.store')->middleware('auth');
Route::get('division/edit/{id}', [DivisionController::class, 'edit'])->name('division.edit')->middleware('auth');
Route::post('division/update/{id}', [DivisionController::class, 'update'])->name('division.update')->middleware('auth');
Route::get('division/delete/{id}', [DivisionController::class, 'delete'])->name('division.delete')->middleware('auth');
Route::post('division/status-update', [DivisionController::class, 'statusUpdate'])->name('division.statusupdate')->middleware('auth');




//employee
Route::get('employee/add1', [EmployeeController::class, 'add'])->name('add.employee')->middleware('auth');
Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store')->middleware('auth');
Route::get('employee', [EmployeeController::class, 'index'])->name('employee.list')->middleware('auth');
Route::get('employee/history', [EmployeeController::class, 'history'])->name('employee.history')->middleware('auth');
Route::post('employee/history', [EmployeeController::class, 'history_report'])->name('history_report')->middleware('auth');
Route::get('employee/filter', [EmployeeController::class, 'filter'])->name('employee.filter')->middleware('auth');
Route::post('employee/filter', [EmployeeController::class, 'data'])->name('salesorder.data')->middleware('auth');
Route::get('employee/graph', [EmployeeController::class, 'graph'])->name('employee.graph')->middleware('auth');
Route::post('employee/graph', [EmployeeController::class, 'graphreport'])->name('salesorder.graphreport')->middleware('auth');

Route::get('employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware('auth');
Route::post('employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware('auth');
Route::get('employee/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete')->middleware('auth');
Route::Post('employee/status-update', [EmployeeController::class, 'statusUpdate'])->name('employee.statusupdate')->middleware('auth');
Route::post('employee/remove', [EmployeeController::class, 'removeDealers'])->name('employee.removedealers')->middleware('auth');
Route::post('employee/removeexp', [EmployeeController::class, 'removeworkexp'])->name('employee.removeworkexp')->middleware('auth');
Route::post('employee/removerefree', [EmployeeController::class, 'removerefree'])->name('employee.removerefree')->middleware('auth');
Route::post('employee/state', [EmployeeController::class, 'getState'])->name('getState')->middleware('auth');
Route::post('employee/city', [EmployeeController::class, 'getCity'])->name('getCity')->middleware('auth');
Route::post('employee/local-goverment', [EmployeeController::class, 'localgoverment'])->name('localgoverment')->middleware('auth');
Route::post('employee', [EmployeeController::class, 'daily_report'])->name('daily_report')->middleware('auth');
Route::post('employee/checkemail', [EmployeeController::class, 'checkemail'])->name('employee.checkemail')->middleware('auth');
Route::post('employee/export', [EmployeeController::class, 'export'])->name('employee.export')->middleware('auth');
//::post('employee/residentialstate',[EmployeeController::class, 'getResidentialState'])->name('getResidentialState');
Route::post('employee/filter/exports', [EmployeeController::class, 'dataExport'])->name('filter.export')->middleware('auth');
Route::post('employee/leaveAssign/{id}', [EmployeeController::class, 'StoreLeave'])->name('assign.leaveemployee')->middleware('auth');
Route::get('employee/LeaveAssign/{id}', [EmployeeController::class, 'AssignLeave'])->name('employee.assign')->middleware('auth');
Route::post('employee/Permission/{id}', [EmployeeController::class, 'StorePermission'])->name('assign.permissionemployee')->middleware('auth');


Route::post('employee/department', [EmployeeController::class, 'getDepartment'])->name('getDepartment')->middleware('auth');
Route::post('employee/unit', [EmployeeController::class, 'getUnit'])->name('getUnit')->middleware('auth');
Route::post('employee/employeelist', [EmployeeController::class, 'getemployeelist'])->name('getemployeelist')->middleware('auth');

// Route::get('employee/profile/{id}',[EmployeeController::class, 'employeeprofile'])->name('employee.profile')->middleware('auth');
// Route::post('employee/profile/{id}',[EmployeeController::class, 'employeeprofileupdate'])->name('employee.profile.update')->middleware('auth');

//TransferClass
Route::get('transferclass', [TransferClassController::class, 'index'])->name('transferclass.list')->middleware('auth');
Route::get('transferclass/add', [TransferClassController::class, 'add'])->name('add.transferclass')->middleware('auth');
Route::post('transferclass/store', [TransferClassController::class, 'store'])->name('transferclass.store')->middleware('auth');
Route::get('transferclass/edit/{id}', [TransferClassController::class, 'edit'])->name('transferclass.edit')->middleware('auth');
Route::post('transferclass/update/{id}', [TransferClassController::class, 'update'])->name('transferclass.update')->middleware('auth');
Route::get('transferclass/delete/{id}', [TransferClassController::class, 'delete'])->name('transferclass.delete')->middleware('auth');
Route::post('transferclass/status-update', [TransferClassController::class, 'statusUpdate'])->name('transferclass.statusupdate')->middleware('auth');

//TransferCategory->middleware('auth');
Route::get('transfercategory', [TransferCategoryController::class, 'index'])->name('transfercategory.list')->middleware('auth');
Route::get('transfercategory/add', [TransferCategoryController::class, 'add'])->name('add.transfercategory')->middleware('auth');
Route::post('transfercategory/store', [TransferCategoryController::class, 'store'])->name('transfercategory.store')->middleware('auth');
Route::get('transfercategory/edit/{id}', [TransferCategoryController::class, 'edit'])->name('transfercategory.edit')->middleware('auth');
Route::post('transfercategory/update/{id}', [TransferCategoryController::class, 'update'])->name('transfercategory.update')->middleware('auth');
Route::get('transfercategory/delete/{id}', [TransferCategoryController::class, 'delete'])->name('transfercategory.delete')->middleware('auth');
Route::post('transfercategory/status-update', [TransferCategoryController::class, 'statusUpdate'])->name('transfercategory.statusupdate')->middleware('auth');

//TransferType
Route::get('transfertype', [TransferTypeController::class, 'index'])->name('transfertype.list')->middleware('auth');
Route::get('transfertype/add', [TransferTypeController::class, 'add'])->name('add.transfertype')->middleware('auth');
Route::post('tranfertype/store', [TransferTypeController::class, 'store'])->name('transfertype.store')->middleware('auth');
Route::get('teansfertype/edit/{id}', [TransferTypeController::class, 'edit'])->name('transfertype.edit')->middleware('auth');
Route::post('transfertype/update/{id}', [TransferTypeController::class, 'update'])->name('transfertype.update')->middleware('auth');
Route::get('transfertype/delete/{id}', [TransferTypeController::class, 'delete'])->name('transfertype.delete')->middleware('auth');
Route::post('transfertype/status-update', [TransferTypeController::class, 'statusUpdate'])->name('transfertype.statusupdate')->middleware('auth');

// Transfer
Route::get('Transfer', [TransferController::class, 'index'])->name('transfer.list')->middleware('auth');
Route::get('Transfer/transferinitiationform', [TransferController::class, 'add'])->name('add.transfer')->middleware('auth');
Route::post('Transfer/store', [TransferController::class, 'store'])->name('transfer.store')->middleware('auth');
Route::get('Transfer/edit/{id}', [TransferController::class, 'edit'])->name('transfer.edit')->middleware('auth');
Route::post('Transfer/update/{id}', [TransferController::class, 'update'])->name('transfer.update')->middleware('auth');
Route::get('Transfer/delete/{id}', [TransferController::class, 'delete'])->name('transfer.delete')->middleware('auth');
Route::post('fetch-OfficialInfo', [TransferController::class, 'fetchOfficialInfo']);
Route::post('FetchDepartment', [TransferController::class, 'fetchDepart']);
Route::post('FetchFaculty', [TransferController::class, 'fetchFaculty']);
Route::post('FetchUnit', [TransferController::class, 'fetchUnit']);
Route::get('TransferAudit', [TransferController::class, 'audit'])->name('transfer.audit')->middleware('auth');
Route::post('TransferAuditDetails', [TransferController::class, 'audit_details'])->name('transfer.audit_details')->middleware('auth');
Route::get('TransferPreviousList', [TransferController::class, 'alltransfer'])->name('transfer.PreviousList')->middleware('auth');

Route::get('Transfer/OtherForm', [TansferOtherController::class, 'add'])->name('transfer.other')->middleware('auth');
Route::post('TransferOther/store', [TansferOtherController::class, 'store'])->name('transferother.store')->middleware('auth');
Route::post('transfer/export-pdf', [TransferController::class, 'export_pdf'])->name('transfer.export-pdf')->middleware('auth');


//TransferReason
Route::get('transferreason', [TransferReasonController::class, 'index'])->name('transferreason.list')->middleware('auth');
Route::get('transferreason/add', [TransferReasonController::class, 'add'])->name('add.transferreason')->middleware('auth');
Route::post('transferreason/store', [TransferReasonController::class, 'store'])->name('transferreason.store')->middleware('auth');
Route::get('transferreason/edit/{id}', [TransferReasonController::class, 'edit'])->name('transferreason.edit')->middleware('auth');
Route::post('transferreason/update/{id}', [TransferReasonController::class, 'update'])->name('transferreason.update')->middleware('auth');
Route::get('transferreason/delete/{id}', [TransferReasonController::class, 'delete'])->name('transferreason.delete')->middleware('auth');
Route::post('transferreason/status-update', [TransferReasonController::class, 'statusUpdate'])->name('transferreason.statusupdate')->middleware('auth');

// Process Transfer
Route::get('processtransfer', [ProcessTransferController::class, 'index'])->name('processtransfer.list')->middleware('auth');
Route::get('processtransfer/add', [ProcessTransferController::class, 'add'])->name('add.processtransfer')->middleware('auth');
Route::post('processtransfer/store', [ProcessTransferController::class, 'store'])->name('processtransfer.store')->middleware('auth');
Route::get('processtransfer/edit/{id}', [ProcessTransferController::class, 'edit'])->name('processtransfer.edit')->middleware('auth');
Route::post('processtransfer/update/{id}', [ProcessTransferController::class, 'update'])->name('processtransfer.update')->middleware('auth');
Route::get('processtransfer/delete/{id}', [ProcessTransferController::class, 'delete'])->name('processtransfer.delete')->middleware('auth');

// Employee dashboard
Route::get('emp_dashboard/employeehome', [App\Http\Controllers\EmpController::class, 'index'])->name('employeehome.emp_dashboard')->middleware('auth');
// Route::get('emp_dashboard/list', [App\Http\Controllers\EmpController::class, 'list'])->name('list.emp_dashboard');
Route::get('emp_dashboard/read-all-notification', [EmpController::class, 'readAllNotification'])->name('read-all-notification');
Route::get('emp_dashboard/LeaveBalance', [EmpController::class, 'LeaveBalanceView'])->name('LeaveBalanceview');

Route::get('emp_dashboard/profile', [EmpController::class, 'employeeprofile'])->name('emp_dashboard.profile')->middleware('auth');
Route::post('emp_dashboard/profile', [EmpController::class, 'employeeprofileupdate'])->name('emp_dashboard.profile.update')->middleware('auth');


//Authorize Transfer Request List
Route::get('authorizetransfer', [AuthorizeTransferController::class, 'index'])->name('authorizetransfer.list')->middleware('auth');
Route::get('authorizetransfer/add', [AuthorizeTransferController::class, 'add'])->name('add.authorizetransfer')->middleware('auth');
Route::post('authorizetransfer/store', [AuthorizeTransferController::class, 'store'])->name('authorizetransfer.store')->middleware('auth');
Route::get('authorizetransfer/edit/{id}', [AuthorizeTransferController::class, 'edit'])->name('authorizetransfer.edit')->middleware('auth');
Route::post('authorizetransfer/update/{id}', [AuthorizeTransferController::class, 'update'])->name('authorizetransfer.update')->middleware('auth');
Route::get('authorizetransfer/delete/{id}', [AuthorizeTransferController::class, 'delete'])->name('authorizetransfer.delete')->middleware('auth');

//Approve Transfer
Route::get('approvetransfer', [ApproveTransferController::class, 'index'])->name('approvetransfer.list')->middleware('auth');
Route::get('approvetransfer/add', [ApproveTransferController::class, 'add'])->name('add.approvetransfer')->middleware('auth');
Route::post('approvetransfer/store', [ApproveTransferController::class, 'store'])->name('approvetransfer.store')->middleware('auth');
Route::get('approvetransfer/edit/{id}', [ApproveTransferController::class, 'edit'])->name('approvetransfer.edit')->middleware('auth');
Route::post('approvetransfer/update/{id}', [ApproveTransferController::class, 'update'])->name('approvetransfer.update')->middleware('auth');
Route::get('approvetransfer/delete/{id}', [ApproveTransferController::class, 'delete'])->name('approvetransfer.delete')->middleware('auth');
Route::get('approveform/{id}', [ApproveTransferController::class, 'approveform'])->name('approveform')->middleware('auth');
Route::get('finalapproveform/{id}', [ApproveTransferController::class, 'finalapproveform'])->name('finalapproveform')->middleware('auth');
Route::get('employee/pdf/{id}', [EmployeeController::class, 'pdf'])->name('employee.pdf');

//leave type
Route::get('LeaveType', [LeavetypeController::class, 'create'])->name('add.leavetype')->middleware('auth');
Route::post('LeaveTypeAdd', [LeavetypeController::class, 'store'])->name('leavetype.store')->middleware('auth');
Route::get('LeaveTypeList', [LeavetypeController::class, 'index'])->name('leavetype.index')->middleware('auth');
Route::get('LeaveType/Edit/{id}', [LeavetypeController::class, 'edit'])->name('leavetype.edit')->middleware('auth');
Route::post('LeaveType/update/{id}', [LeavetypeController::class, 'update'])->name('leavetype.update')->middleware('auth');
Route::get('LeaveType/Delete/{id}', [LeavetypeController::class, 'destroy'])->name('leavetype.delete')->middleware('auth');
// Route::get('LeaveYearList', [LeavetypeController::class, 'leavesetting'])->name('leavetype.Yearindex')->middleware('auth');
Route::get('LeaveTypeYear/Edit', [LeavetypeController::class, 'yearedit'])->name('leavetype.Yearedit')->middleware('auth');
Route::post('LeaveTypeYear/update', [LeavetypeController::class, 'yearupdate'])->name('leavetype.Yearupdate')->middleware('auth');
Route::post('LeaveType', [LeavetypeController::class, 'FetchLeaveCycle']);




//Leave
Route::get('Leave', [LeaveController::class, 'create'])->name('leave.add')->middleware('auth');
Route::post('InstituteLeaveRequestAdd', [LeaveController::class, 'store'])->name('leaveStore')->middleware('auth');
Route::get('LeaveRequestList', [LeaveController::class, 'index'])->name('leave.index')->middleware('auth');
Route::post('fetch-department', [LeaveController::class, 'fetchDepart']);
Route::post('fetch-unit', [LeaveController::class, 'fetchUnit']);
Route::post('fetch-employee', [LeaveController::class, 'fetchEmp']);
Route::post('fetch-department-employee', [LeaveController::class, 'fetchEmployee']);
Route::post('fetch-LeaveType', [LeaveController::class, 'fetchLeaveType']);
Route::post('fetch-Count', [LeaveController::class, 'fetchCountData']);
Route::get('Leave/Edit/{id}', [LeaveController::class, 'edit'])->name('leave.edit')->middleware('auth');
Route::post('Leave/Update/{id}', [LeaveController::class, 'update'])->name('leave.update')->middleware('auth');
Route::get('Leave/Delete/{id}', [LeaveController::class, 'destroy'])->name('leave.delete')->middleware('auth');
Route::post('Leave/export-pdf', [LeaveController::class, 'export_pdf'])->name('leave.export-pdf')->middleware('auth');

//emp_assign_leave
// Route::get('EmpList', [AssignLeaveController::class, 'index'])->name('assign.index')->middleware('auth');
// Route::post('AssignLeave', [AssignLeaveController::class, 'store'])->name('assign.leave')->middleware('auth');

//EmployeeLeave
Route::get('LeaveRequest', [EmployeeLeaveController::class, 'LeaveView'])->name('employee.leave.request')->middleware('auth');
Route::post('/EmployeeLeaveRequestAdd', [EmployeeLeaveController::class, 'EmployeeLeaveAssign'])->name('Employee.leave.store')->middleware('auth');
Route::get('EmployeeLeaveRequest/Delete/{id}', [EmpController::class, 'destroy'])->name('leaveRequest.delete')->middleware('auth');
Route::get('EmployeeLeaveRequestList', [EmployeeLeaveController::class, 'index'])->name('EmployeeLeave.index')->middleware('auth');
Route::get('EmployeeLeaveRequestList/Edit/{id}', [EmployeeLeaveController::class, 'edit'])->name('EmployeeLeave.edit')->middleware('auth');
Route::post('EmployeeLeaveRequestList/Update/{id}', [EmployeeLeaveController::class, 'update'])->name('EmployeeLeave.update')->middleware('auth');
// Route::post('Leave/Date', [EmployeeLeaveController::class,'checkdate'])->name('leave.date')->middleware('auth');

//InstitueRoles
Route::get('Roles', [InstituteRolesController::class, 'index'])->name('insti.roles')->middleware('auth');
Route::post('Roles/Store', [InstituteRolesController::class, 'store'])->name('insti.store')->middleware('auth');
Route::get('Roles/Edit/{id}', [InstituteRolesController::class, 'edit'])->name('insti.edit')->middleware('auth');
Route::post('Roles/Update/{id}', [InstituteRolesController::class, 'update'])->name('insti.update')->middleware('auth');
Route::get('Roles/Delete/{id}', [InstituteRolesController::class, 'destroy'])->name('insti.delete')->middleware('auth');

//InstituePermissions
Route::get('Permissions', [InstitutePermissionController::class, 'index'])->name('insti.permissions')->middleware('auth');
Route::post('Permissions/Store', [InstitutePermissionController::class, 'store'])->name('permissions.store')->middleware('auth');
Route::get('Permissions/Edit/{id}', [InstitutePermissionController::class, 'edit'])->name('permissions.edit')->middleware('auth');
Route::post('Permissions/Update/{id}', [InstitutePermissionController::class, 'update'])->name('permissions.update')->middleware('auth');
Route::get('Permissions/Delete/{id}', [InstitutePermissionController::class, 'destroy'])->name('permissions.delete')->middleware('auth');

//roles and permission for institute
Route::get('RolePermission', [InstiRolePermissonController::class, 'index'])->name('insti.rolespermissions')->middleware('auth');
Route::post('RolePermission/Store', [InstiRolePermissonController::class, 'store'])->name('rolespermissions.store')->middleware('auth');
Route::get('RolePermission/Edit/{id}', [InstiRolePermissonController::class, 'edit'])->name('rolespermissions.edit')->middleware('auth');
Route::post('RolePermission/Update/{id}', [InstiRolePermissonController::class, 'update'])->name('rolespermissions.update')->middleware('auth');
Route::get('RolePermission/Delete/{id}', [InstiRolePermissonController::class, 'destroy'])->name('rolespermissions.delete')->middleware('auth');
Route::post('fetch-Permission', [InstiRolePermissonController::class, 'fetchPermission']);

//Hou View
Route::get('HouLeaveRequestList', [HOULeaveController::class, 'index'])->name('HOULeave.index')->middleware('auth');
Route::get('HodLeaveRequestList', [HOULeaveController::class, 'HODindex'])->name('HODLeave.index')->middleware('auth');
Route::get('HofLeaveRequestList', [HOULeaveController::class, 'HOFindex'])->name('HOFLeave.index')->middleware('auth');


Route::get('destination/approvetransfer', [DestinationApproveController::class, 'index'])->name('destination.list')->middleware('auth');
Route::get('destination/approvetransfer/edit/{id}', [DestinationApproveController::class, 'edit'])->name('destination.edit')->middleware('auth');
Route::post('destination/approvetransfer/update/{id}', [DestinationApproveController::class, 'update'])->name('destination.update')->middleware('auth');
Route::get('destination/approvetransfer/delete/{id}', [DestinationApproveController::class, 'delete'])->name('destination.delete')->middleware('auth');
Route::get('destination/approveform/{id}', [DestinationApproveController::class, 'approveform'])->name('destination.approveform')->middleware('auth');
Route::get('destination/finalapproveform/{id}', [DestinationApproveController::class, 'finalapproveform'])->name('destination.finalapproveform')->middleware('auth');

Route::post('FetchInsti', [TransferController::class, 'fetchInsti']);