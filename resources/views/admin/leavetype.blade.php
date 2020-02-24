@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')
<div class="container-fluid">
<!-- <a class="btn btn-success" href="javascript:void(0)" id="createNewLeavetype"> Create New LeaveType</a> -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">LeaveType</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                        <th>LeaveType ID</th>
                        <th>LeaveType Name</th>
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
                <form id="leavetypeForm" name="leavetypeForm" class="form-horizontal">
                   <input type="hidden" name="leavetype_id" id="leavetype_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Leavetype Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="leavename" name="leavename" placeholder="Enter Leavetype Name" value="" maxlength="50" required="">
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
        ajax: "{{ route('ajaxleavetypes.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'leavename', name: 'leavename'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    //Create employee 
    $('#createNewLeavetype').click(function () {
        $('#saveBtn').val("create-role");
        $('#leavetype_id').val('');
        $('#leavetypeForm').trigger("reset");
        $('#modelHeading').html("Create New Leavetype");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editLeavetype', function () {
      var leavetype_id = $(this).data('id');
      $.get("{{ route('ajaxleavetypes.index') }}" +'/' + leavetype_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Leavetypes");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#leavetype_id').val(data.id);
          $('#leavename').val(data.leavename);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#leavetypeForm').serialize(),
          url: "{{ route('ajaxleavetypes.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#leavetypeForm').trigger("reset");
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
    $('body').on('click', '.deleteLeavetype', function () {
     
        var leavetype_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxleavetypes.store') }}"+'/'+leavetype_id,
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