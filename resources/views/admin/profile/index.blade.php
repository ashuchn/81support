@extends('admin.layout.layout')
@section('css')
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile Settings</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (Session::has('success_msg'))
                            <div class="alert alert-block alert-success">
                                <i class=" fa fa-check cool-green "></i>
                                {{ nl2br(Session::get('success_msg')) }}
                            </div>
                        @endif
                        @if (Session::has('err_msg'))
                            <div class="alert alert-block alert-danger">
                                <i class=" fa fa-times cool-green "></i>
                                {{ nl2br(Session::get('err_msg')) }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update Email and Password</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form>
                                            <label for="email">Email</label>
                                            <div class="input-group mb-3">
                                                <input type="email" class="form-control" placeholder="Email"
                                                    value="{{ $admin_email }}" disabled>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <form method="post" action="{{ route('admin.profile.update') }}">
                                            @csrf
                                            <label for="email">Change Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Current Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('password'))
                                                <div class="text-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                            <div class="input-group mt-3">
                                                <input type="password" name="new_password" class="form-control"
                                                    placeholder="New Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('new_password'))
                                                <div class="text-danger">{{ $errors->first('new_password') }}</div>
                                            @endif
                                            <div class="input-group mt-3">
                                                <input type="password" name="confirm_password" class="form-control"
                                                    placeholder="Confirm Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('confirm_password'))
                                                <div class="text-danger">{{ $errors->first('confirm_password') }}</div>
                                            @endif
                                            <div class="row mt-3">
                                                <div class="col-4">
                                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>


    </div>
@endsection

@section('script')
@endsection
