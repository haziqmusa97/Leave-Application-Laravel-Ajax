@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<!-- <div class="container">
    <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Department</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> -->
<input type="hidden" value="<?php echo $val=Session::get('id');?>" class="form-control" disabled>
<input type="hidden" value="<?php echo $val=Session::get('dept_name');?>" class="form-control" disabled>
<div class="container-fluid">
<a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Employee</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>AL Balance</th>
                        <th>MC Balance</th>
                        <th>Action</th>
                      </thead>

                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">

            	<!-- Form start -->
                <form id="employeeForm" name="employeeForm" class="form-horizontal">
                   <input type="hidden" name="employee_id" id="employee_id">
                   <input type="hidden" name="AL" id="AL">
                   <input type="hidden" name="MC" id="MC">
                   <input type="hidden" name="LB_id" id="LB_id">
                   <input type="hidden" name="DP" id="DP" value="<?php echo $val=Session::get('dept_name');?>">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">UserName</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter UserName" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Position</label>
                       <div class="col-sm-12">
                         <select class="form-control" id="role_name" name="role_name" >
                         @foreach($role as $de)
                            <option value="{{$de->id}}">{{$de->role_name}}</option>
                          @endforeach
                        </select>
                        </div>
                   </div>

                   <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Department</label>
                       <div class="col-sm-12">
                         <select class="form-control" id="dept_name" name="dept_name" >
                          @foreach($depart as $dep)
                            <option value="{{$dep->id}}">{{$dep->dept_name}}</option>
                          @endforeach
                        </select>
                        </div>
                   </div>
                   <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Annual Leave Balance</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="AL" name="AL" placeholder="Enter Annual Leave Balance" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Medical Leave Balance</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="MC" name="MC" placeholder="Enter Medical Leave Balance" value="" maxlength="50" required="">
                        </div>
                    </div>

                   
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
                <!-- form end -->
                
            </div>
        </div>
    </div>
</div>

       
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxemployees.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'username', name: 'username'},
            {data: 'RN', name: 'RN'},
            {data: 'DP', name: 'DP'},
            {data: 'AL', name: 'AL'},
            {data: 'MC', name: 'MC'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    //Create employee 
    $('#createNewEmployee').click(function () {
        $('#saveBtn').val("create-employee");
        $('#employee_id').val('');
        $('#employeeForm').trigger("reset");
        $('#modelHeading').html("Create New Employee");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editEmployee', function () {
      var employee_id = $(this).data('id');
      $.get("{{ route('ajaxemployees.index') }}" +'/' + employee_id +'/edit', function (data) {
        console.log(data);
          $('#modelHeading').html("Edit Employee");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#employee_id').val(data.id);
          $('#username').val(data.username);
          $('#password').val(data.password);
          $('#role_name').val(data.role_name);
          $('#dept_name').val(data.dept_name);
          $('#AL').val(data.AL);
          $('#MC').val(data.MC);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        var dept_name = $("#dept_name").val();   
        var dp = $("#DP").val();  

        if(dept_name == dp || dept_name == 3){
        $.ajax({
          data: $('#employeeForm').serialize(),
          url: "{{ route('ajaxemployees.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#employeeForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
        }
        else{
          alert("Wrong Department");
        }

    });
    

    //Delete employee
    $('body').on('click', '.deleteEmployee', function () {
     
        var employee_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxemployees.store') }}"+'/'+employee_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });

</script>

@endsection

@section('scripts')
@endsection