@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<input type="hidden" value="<?php echo $val=Session::get('id');?>" class="form-control" disabled>
<input type="hidden" value="<?php echo $val=Session::get('dept_name');?>" class="form-control" disabled>
<div class="container-fluid">
<!-- <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a> -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Leave Application</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                      <th>Employee ID</th>
                      <th>Employee Department</th>
                <th>Name</th>
                <th>Leave Type</th>
                <th>Start</th>
                <th>End</th>
                <th>Number Days</th>
                <th>Status</th>
                <th>Description</th>
                <th>ALB</th>
                <th width="280px">Action</th>
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
                <form id="approveForm" name="approveForm" class="form-horizontal">
                <input type="hidden" name="approve_id" id="approve_id" ">
                <input type="hidden" name="emp_id" id="emp_id" ">
                <input type="hidden" name="numday" id="numday" ">
                <?php echo $val=Session::get('');?>
                   <input type="hidden" name="approves_id" id="approves_id" value="<?php echo $val=Session::get('id');?>">
                   
                   <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">status</label>
                       <div class="col-sm-12">
                         <select class="form-control" id="status" name="status" >
                          <option value="Pending">Pending</option>
                           <option value="Rejected">Rejected</option>
                           <option value="Approve">Approve</option>
                        </select>
                        </div>
                   </div>

                   <!-- <input type="text" name="ALB" id="ALB" value="">  -->

                    <div class="form-group">
                        <!-- <label for="name" class="col-sm-2 control-label">Date Start</label> -->
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" id="date_start" name="date_start" placeholder="Enter Date Start" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- <label for="name" class="col-sm-2 control-label">Date End</label> -->
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" id="date_end" name="date_end" placeholder="Enter Date End" value="" maxlength="50" required="">
                        </div>
                    </div>


                    

                   <input type="hidden" id="leaveType_name" name="leaveType_name" >
                   <input type="hidden" id="descr" name="descr" >
                   
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
//Auto refresh
// function loadlink(){
//     $('#data-table').load('admin.leavemgt',function () {
//          $(this).unwrap();
//     });
// }

// loadlink(); // This will run on page load
// setInterval(function(){
//     loadlink() // this will run after every 5 seconds
// }, 1000);


//ajax funtion
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxapproves.index') }}",
        columns: [
            {data: 'emp_id', name: 'emp_id'},
            {data: 'EDN', name: 'EDN'},
            {data: 'us', name: 'us'},
            {data: 'LN', name: 'LN'},
            {data: 'date_start', name: 'date_start'},
            {data: 'date_end', name: 'date_end'},
            {data: 'numday', name: 'numday'},
            {data: 'status', name: 'status'},
            {data: 'descr', name: 'descr'},
            {data: 'ALB', name: 'ALB'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    setInterval( function () {
        table.ajax.reload();
        }, 10000 );

    
     
    //Create employee 
    $('#createNewApprove').click(function () {
        $('#saveBtn').val("create-approve");
        $('#approve_id').val('');
        $('#approveForm').trigger("reset");
        $('#modelHeading').html("Create New Approve");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editApprove', function () {
        
      var approve_id = $(this).data('id');
      $.get("{{ route('ajaxapproves.index') }}" +'/' + approve_id +'/edit', function (data) {
        console.log(data);
          $('#modelHeading').html("Edit Approve");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#approve_id').val(data.id);
          $('#emp_id').val(data.emp_id);
          $('#leaveType_name').val(data.leaveType_name);
          $('#date_start').val(data.date_start);
          $('#date_end').val(data.date_end);
          $('#numday').val(data.numday);
          $('#status').val(data.status);
          $('#descr').val(data.descr);
          $('#ALB').val(data.ALB);
          //$('#approves_id').val(data.approves_id);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#approveForm').serialize(),
          url: "{{ route('ajaxapproves.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#approveForm').trigger("reset");
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
    $('body').on('click', '.deleteApprove', function () {
     
        var approve_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxapproves.store') }}"+'/'+approve_id,
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