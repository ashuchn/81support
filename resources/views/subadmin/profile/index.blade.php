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
                                                <h3 class="p-0 m-0">
                                                    {{ $subadmin->name }}
                                                </h3>
                                                <p class="mb-0"></p>
                                                <div class="text-muted">
                                                    <small>
                                                        Joined {{ $subadmin->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 col-sm-auto justify-content-center d-flex">
                                            <img title="Change Image" onclick="chooseFile();" id="frame"
                                                style="width: 140px; height: 140px; cursor: pointer; object-fit: cover;"
                                                src="{{ asset('dashboard-nazox/assets/images/users/avatar-2.jpg') }}"
                                                class="rounded-circle" alt="user">
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
                                @if (session('success'))
                                    <div class="alert alert-success"><strong>{{ Session::get('success') }}</strong></div>
                                    <?php Session::forget('success'); ?>
                                @endif
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <form id="updateData" class="form" method="post"
                                                action="{{ route('subadmin.profile.update') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="d-none">
                                                    <input name="profile_image" class="form-control" type="file"
                                                        id="formFile" accept="image/*" onchange="preview()">
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6 mb-3">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input name="name" type="text"
                                                                            class="form-control @error('name') is-invalid @enderror"
                                                                            value="{{ old('name', $subadmin->name) }}"
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
                                                            <div class="col-12 col-lg-6 mb-3">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input name="mobile" type="text"
                                                                            class="form-control @error('mobile') is-invalid @enderror"
                                                                            value="{{ old('mobile', $subadmin->mobile) }}"
                                                                            id="floatingInput" placeholder="Mobile"
                                                                            onkeyup="turnButtonOn()" />
                                                                        <label for="floatingInput">Mobile</label>
                                                                    </div>
                                                                    @error('mobile')
                                                                        <span class="text-danger" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6 mb-3">
                                                                <div class="form-group">
                                                                    <div class="form-floating">
                                                                        <input type="email" class="form-control"
                                                                            value="{{ old('email', $subadmin->email) }}"
                                                                            id="floatingInput" placeholder="Email"
                                                                            onkeyup="turnButtonOn()" disabled />
                                                                        <label for="floatingInput">Email</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button id="saveButton" class="float-end btn btn-primary"
                                                                    type="submit" disabled="true"
                                                                    onclick="event.preventDefault(); document.getElementById('updateData').submit();">
                                                                    Save Changes
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
                                <form id="logout-form" action="{{ route('subadmin.logout') }}" method="get"
                                    class="d-none">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Page-content -->
    </div>
@endsection

@section('script')

    <script>
        function chooseFile() {
            turnButtonOn();
            document.getElementById("formFile").click();
        }

        function preview() {
            frame.src = "";
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

        function clearImage() {
            document.getElementById('formFile').value = null;
            frame.src = "";
        }

        function turnButtonOn() {
            document.getElementById("saveButton").disabled = false;
        }
    </script>

@endsection
