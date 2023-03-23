@extends('subadmin.layout.layout')
@section('title', 'Dashboard | 81 Support')
@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Profile</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">81 Support</li>
                                    <li class="breadcrumb-item active"><a
                                            href="{{ route('subadmin.profile.index') }}">Profile</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-sm-left mb-2 mb-sm-0">
                                                <h3 class="p-0 m-0 text-nowrap">
                                                    </h3>
                                                <p class="mb-0"></p>
                                                <div class="text-muted">
                                                    <small>
                                                        Joined 
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 col-sm-auto justify-content-center d-flex">
                                            @if ($profile->profile_image == 'default.png')
                                                <img title="Change Image" onclick="chooseFile();" id="frame"
                                                    style="width: 140px; height: 140px; cursor: pointer; object-fit: cover;"
                                                    src="{{ asset('dist/assets/images/user/default.png') }}"
                                                    class="rounded-circle" alt="user">
                                            @else
                                                <img title="Change Image" onclick="chooseFile();" id="frame"
                                                    style="width: 140px; height: 140px; cursor: pointer; object-fit: cover;"
                                                    src="{{ asset('dashboard-nazox/assets/images/users/avatar-2.jpg')}}"
                                                    class="rounded-circle" alt="user">
                                            @endif
                                        </div>
                                        @error('profile_image')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <hr>
                                        <div class="d-flex gap-3">
                                            <span style="font-size: 30px;"><i class="ti ti-lg ti-brand-twitter"></i></span>
                                            <span style="font-size: 30px;"><i class="ti ti-lg ti-brand-facebook"></i></span>
                                            <span style="font-size: 30px;"><i class="ti ti-lg ti-brand-linkedin"></i></span>
                                            <span style="font-size: 30px;"><i
                                                    class="ti ti-lg ti-brand-instagram"></i></span>
                                            <span style="font-size: 30px;"><i class="ti ti-lg ti-brand-youtube"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <form id="updateData" class="form" method="post"
                                                action="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="d-none">
                                                    <input name="profile_image" class="form-control" type="file"
                                                        id="formFile" accept="image/*" onchange="preview()">
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input name="name" type="text"
                                                                            class="form-control @error('name') is-invalid @enderror"
                                                                            value=""
                                                                            id="floatingInput" placeholder="Username"
                                                                            onkeyup="turnButtonOn()" />
                                                                        <label for="floatingInput">Name</label>
                                                                    </div>
                                                                    @error('name')
                                                                        <span class="text-danger" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input name="profession" type="text"
                                                                            class="form-control @error('profession') is-invalid @enderror"
                                                                            value=""
                                                                            id="floatingInput" placeholder="Username"
                                                                            onkeyup="turnButtonOn()" />
                                                                        <label for="floatingInput">Profession</label>
                                                                    </div>
                                                                    @error('profession')
                                                                        <span class="text-danger" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input type="email" class="form-control"
                                                                            value=""
                                                                            id="floatingInput" placeholder="Email"
                                                                            onkeyup="turnButtonOn()" disabled />
                                                                        <label for="floatingInput">Email</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control"
                                                                            value=""
                                                                            id="floatingInput" placeholder="Username"
                                                                            onkeyup="turnButtonOn()" disabled />
                                                                        <label for="floatingInput">Username</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col d-flex justify-content-end">
                                        <button id="saveButton" class="btn btn-primary" type="submit" disabled="true"
                                            onclick="event.preventDefault(); document.getElementById('updateData').submit();">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Logout</h6>
                                <p class="card-text">Sign out of your account</p>
                                <button type="button"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="btn btn-outline-secondary">Logout</button>
                                </a>
                                <form id="logout-form" action="{{ route('subadmin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Page-content -->
    @endsection
