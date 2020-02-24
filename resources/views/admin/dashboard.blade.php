@extends('layouts.master')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<div class="container-fluid">
<!-- <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Create New Employee</a> -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">All Employee List</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table data-table">
                      <thead class=" text-primary">
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Department</th>
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

        <script>
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
           {data: 'role_name', name: 'role_name'},
           {data: 'dept_name', name: 'dept_name'},
       ]
   });

  });
        
        </script>

@endsection

@section('scripts')
@endsection