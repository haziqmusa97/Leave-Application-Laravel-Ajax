<?php

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
//login page
Route::get('/', function () {
    return view('login');
});

Route::get('/a', function () {
    return view('Userselected');
});

//logout
Route::get('/admin_logout','AdminLogController@admin_logout');
Route::get('/staff_logout','LeaveController@staff_logout');

Route::get('/adminlog', function () {
    return view('adminlog');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/department', function () {
    return view('admin.department');
});
Route::get('/role', function () {
    return view('admin.role');
});
Route::get('/leavetype', function () {
    return view('admin.leavetype');
});

Route::get('/employee', function () {
    

    return view('admin.employee');
});

Route::get('/leave', function () {
    return view('admin.leave');
});

Route::get('/leavemgt', function () {
    return view('admin.leavemgt');
});

Route::get('/emp_profile', function () {
    return view('emp.emp_profile');
});

Route::get('/emp_history', function () {
    return view('emp.emp_history');
});

Route::get('/emp_leave', function () {
    return view('emp.emp_leave');
});

//employee
Route::resource('ajaxemployees','employeeAjaxController');
Route::resource('ajaxleaves','LeaveAjaxController');
Route::resource('ajaxapproves','ApprovesAjaxController');
Route::resource('ajaxdepartments','DepartmentAjaxController');
Route::resource('ajaxroles','RoleAjaxController');
Route::resource('ajaxleavetypes','LeavetypeAjaxController');

Route::get('/employee', 'DepartmentAjaxController@index2');

//login staff
Route::get('/login-check','LeaveController@login_check');
Route::post('/customer_login','LeaveController@customer_login');

//login admin
Route::get('/adminlogin-check','AdminLogController@adminlogin_check');
Route::post('/admin_login','AdminLogController@admin_login');


//count
Route::get('/emp_leave','LeaveAjaxController@count');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
