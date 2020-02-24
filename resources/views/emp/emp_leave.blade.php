@extends('layouts.childemp')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')
<input type="hidden" value="<?php echo $val=Session::get('id');?>" class="form-control" disabled>
<input type="hidden" value="<?php echo $val=Session::get('MC');?>" class="form-control" disabled>
<input type="hidden" value="<?php echo $val=Session::get('AL');?>" class="form-control" disabled>



<div class="container-fluid" id="balance">
    
</div>
<div class="container-fluid">
<!-- <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a> -->
<a class="btn btn-success" href="javascript:void(0)" id="createNewLeave"> Apply New Leave</a> <br>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Leave History</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                    <a class="btn btn-warning btn-sm"  disabled="true"> Medical Leave Balance :{{$mc}}</a>
                     <a class="btn btn-warning btn-sm"  disabled="true"> Annual Leave Balance  : {{$al}}</a>
                      <thead class=" text-primary">
                      <th>Leave ID</th>
                <th>Leave Type</th>
                <th>Date Start</th>
                <th>Date End</th>
                <th>Number Days</th>
                <th>Description</th>
                <th>Approved By</th>
                <th>Status</th>
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
                <form id="leaveForm" name="leaveForm" class="form-horizontal">
                   <input type="hidden" name="leave_id" id="leave_id">
                   <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $val=Session::get('id');?>">
                   <input type="hidden" name="status" id="status" value="Pending">
                   <input type="hidden" name="approves_id" id="approves_id" value="2">
                   <input type="hidden" name="AL" id="AL" value="{{$al}}">
                   <input type="hidden" name="MC" id="MC" value="{{$mc}}">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date Start</label>
                        <div class="col-sm-12 " >
                            <input type="date" class="form-control"  id="date_start" name="date_start" placeholder="Enter Date Start" onchange="cal()" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date End</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="date_end" name="date_end" placeholder="Enter Date End" onchange="cal()" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Number Days</label>
                        <div class="col-sm-12 " >
                            <input type="text" class="form-control"  id="numday" name="numday" placeholder="Number days" value="" maxlength="50" required="" readonly>
                        </div>
                    </div>


                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Type Leave</label>
                       <div class="col-sm-12">
                         <select class="form-control" id="leaveType_name" name="leaveType_name" >

                           @foreach($LT as $LT)

                            <option value="{{$LT->id}}">{{$LT->leavename}}</option>
                          @endforeach

                        </select>
                        </div>
                   </div>

                   <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="textarea" class="form-control" id="descr" name="descr" placeholder="Enter Description" value="" maxlength="200" required="">
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                    <p>Medical Balance: {{$mc}}</p>
                    <p>Annual Balance: {{$al}}</p>
                </form>
                
            </div>
        </div>
    </div>
</div>
       
<script type="text/javascript"> 

            function GetDays(){
                var date_start = new Date(document.getElementById("date_start").value);
                var date_end = new Date(document.getElementById("date_end").value);
                return parseInt((date_end - date_start) / (24 * 3600 * 1000)+1);
               }

            function cal(){
                if(document.getElementById("date_start")){
                document.getElementById("numday").value=GetDays();
                 }  
             } 

            //  function validateform(){
            //     var leavetype = document.getElementById("leavetype").value;
            //     var AL = {{$al}};

            //     if(leavetype=="Annual Leave"){
            //         document.getElementById("saveBtn").disabled = true;
            //     }
            //  }      



  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxleaves.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'LN', name: 'LN'},
            {data: 'date_start', name: 'date_start'},
            {data: 'date_end', name: 'date_end'},
            {data: 'numday', name: 'numday'},
            {data: 'descr', name: 'descr'},
            {data: 'us', name: 'us'},
            {data: 'status', name: 'status'},
            
            
        ]
    });
    //Auto refreshe
    setInterval( function () {
        table.ajax.reload();
        }, 10000 );



        
     
    //Create employee 
    $('#createNewLeave').click(function () {
        $('#saveBtn').val("create-leave");
        $('#leave_id').val('');
        $('#leaveForm').trigger("reset");
        $('#modelHeading').html("Create New Leave");
        $('#ajaxModel').modal('show');
    });
    

    //Edit employee
    $('body').on('click', '.editLeave', function () {
      var leave_id = $(this).data('id');
      $.get("{{ route('ajaxleaves.index') }}" +'/' + leave_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Leave");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#leave_id').val(data.id);
          $('#username').val(data.username);
          $('#password').val(data.password);
          $('#numday').val(data.numday);
          $('#role_name').val(data.role_name);
          $('#dept_name').val(data.dept_name);
      })
   });
    

    //Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        var numday = $("#numday").val();
        var leaveType_name = $("#leaveType_name").val();    
        var AL = {{$al}};
        var MC = {{$mc}};

        if(numday<=0){
            alert("Wrong Date");
        }

        else if(numday<=AL && leaveType_name == 1){
        $.ajax({
          data: $('#leaveForm').serialize(),
          url: "{{ route('ajaxleaves.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#leaveForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });

        }
        else if(numday<=MC && leaveType_name == 2){
        $.ajax({
          data: $('#leaveForm').serialize(),
          url: "{{ route('ajaxleaves.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#leaveForm').trigger("reset");
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
            alert("Not Enough Balance!");
        }

    });
    

    //Delete employee
    $('body').on('click', '.deleteLeave', function () {
     
        var leave_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxleaves.store') }}"+'/'+leave_id,
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