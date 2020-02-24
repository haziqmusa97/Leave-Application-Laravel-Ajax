@extends('layouts.childemp')

@section('title')
    Dashboard Leave Application
@endsection

@section('content')

<div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Welcome <?php echo $val=Session::get('username');?>
                  </h4>
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">User ID (disabled)</label>
                          <input type="text" value="<?php echo $val=Session::get('id');?>" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fist Name</label>
                          <input type="text" value="<?php echo $val=Session::get('username');?>" class="form-control" readonly>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control">
                        </div>
                      </div> -->
                    </div>
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Role</label>
                          <input type="text" value="<?php echo $val=Session::get('role_name');?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Department</label>
                          <input type="text" value="<?php echo $val=Session::get('dept_name');?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Annual Leave Balance</label>
                          <input type="text" value="<?php echo $val=Session::get('AL');?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div><div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Medical Leave Balance</label>
                          <input type="text" value="<?php echo $val=Session::get('MC');?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div> -->
                    <!-- <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Annual Leave Balance</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Medical Leave Balance</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                    </div> -->
                    
                    <!-- <button type="submit" class="btn btn-primary pull-right">Update Profile</button> -->
                    <div class="clearfix"></div>
                  </form>
                    
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('scripts')
@endsection