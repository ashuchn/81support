@extends('admin.layout.layout')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="{{ url('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">-->
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        @if (session('success'))
            <div class="card-body">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>{{ Session::get('success') }}</h5>
                    <?php Session::forget('success'); ?>
                </div>
            </div>
        @endif



        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><a href="{{ route('admin.add_user') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add User</button></a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Registered Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($user as $key => $userDetails)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($userDetails->image != null || $userDetails->image != '')
                                                        <img src="{{ $userDetails->image }}"
                                                            style="height:50px;width:50px;">
                                                    @else
                                                        <img src="{{ url('public/blank-profile.webp') }}"
                                                            style="height:50px;width:50px;">
                                                    @endif
                                                </td>
                                                <td>{{ $userDetails->name }}</td>
                                                <td>{{ $userDetails->email }}</td>
                                                <td>{{ $userDetails->mobile }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="<?php echo $userDetails->id; ?>" <?php if ($userDetails->status == '1') {
                                                                    echo 'checked';
                                                                } ?>>
                                                            <label class="custom-control-label"
                                                                for="<?php echo $userDetails->id; ?>"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $userDetails->created_at }}</td>
                                                <input type="hidden" id="statusval<?php echo $userDetails->id; ?>"
                                                    value="<?php echo $userDetails->status; ?>">
                                                <input type="hidden" id="user_id<?php echo $userDetails->id; ?>"
                                                    value="<?php echo $userDetails->id; ?>">
                                                <td>


                                                    <a href="{{ route('admin.view_user', ['id' => $userDetails->id]) }}">
                                                        <button type="button" class="btn btn-primary"><i
                                                                class="fa fa-eye"></i></button></a>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete<?php echo $userDetails->id; ?>"><i
                                                            class="fa fa-trash"></i></button>


                                                </td>
                                            </tr>


                                            <div class="modal fade" id="modal-delete<?php echo $userDetails->id; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Alert</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are You Sure You Want To Delete This Item ?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">No</button>
                                                            <a
                                                                href="{{ route('admin.destroy_user', ['id' => $userDetails->id]) }}"><button
                                                                    type="button" class="btn btn-primary">Yes</button></a>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @endforeach

                                    </tbody>
                                </table>
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


        <script>
            $(document).ready(function() {
                $('input[type="checkbox"]').click(function() {
                    if ($(this).prop("checked") == true) {
                        var id = $(this).prop('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('change-status-user') }}",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}',
                                status: 0
                            },
                        });
                    } else if ($(this).prop("checked") == false) {
                        var id = $(this).prop('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('change-status-user') }}",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}',
                                status: 1
                            }
                        });
                    }
                });
            });
        </script>



    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    </script>
@endsection
