@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<div class="container-fluid">
<a class="btn btn-success" href="javascript:void(0)" id="createNewDepartment"> Create New Department</a>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Department</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                        <th>Department ID</th>
                        <th>Department Name</th>
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
                <form id="departmentForm" name="departmentForm" class="form-horizontal">
                   <input type="hidden" name="department_id" id="department_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Department Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="Enter Department Name" value="" maxlength="50" required="">
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
        ajax: "{{ route('ajaxdepartments.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'dept_name', name: 'dept_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    //Create employee 
    $('#createNewDepartment').click(function () {
        $('#saveBtn').val("create-department");
        $('#department_id').val('');
        $('#departmentForm').trigger("reset");
        $('#modelHeading').html("Create New Department");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editDepartment', function () {
      var department_id = $(this).data('id');
      $.get("{{ route('ajaxdepartments.index') }}" +'/' + department_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Department");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#department_id').val(data.id);
          $('#dept_name').val(data.dept_name);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#departmentForm').serialize(),
          url: "{{ route('ajaxdepartments.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#departmentForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    

    //Delete employee
    $('body').on('click', '.deleteDepartment', function () {
     
        var department_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxdepartments.store') }}"+'/'+department_id,
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