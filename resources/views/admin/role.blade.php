@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<div class="container-fluid">
<!-- <a class="btn btn-success" href="javascript:void(0)" id="createNewRole"> Create New Role</a> -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Role</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                        <th>Role ID</th>
                        <th>Role Name</th>
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
                <form id="roleForm" name="roleForm" class="form-horizontal">
                   <input type="hidden" name="role_id" id="role_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Role Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Enter Role Name" value="" maxlength="50" required="">
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
        ajax: "{{ route('ajaxroles.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'role_name', name: 'role_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    //Create employee 
    $('#createNewRole').click(function () {
        $('#saveBtn').val("create-role");
        $('#role_id').val('');
        $('#roleForm').trigger("reset");
        $('#modelHeading').html("Create New Role");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editRole', function () {
      var role_id = $(this).data('id');
      $.get("{{ route('ajaxroles.index') }}" +'/' + role_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Role");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#role_id').val(data.id);
          $('#role_name').val(data.role_name);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#roleForm').serialize(),
          url: "{{ route('ajaxroles.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#roleForm').trigger("reset");
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
    $('body').on('click', '.deleteRole', function () {
     
        var role_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxroles.store') }}"+'/'+role_id,
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