@extends('subadmin.layout.layout')
@section('title', 'Product Management')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"> --}}
    {{-- <link rel="stylesheet" href=""> --}}
    <link rel="stylesheet"
        href="{{ url('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('content')


    <div class="main-content">
        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>{{ Session::get('success') }}</h5>
                    <?php Session::forget('success'); ?>
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Reviews</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">81 Support</li>
                                    <li class="breadcrumb-item active">Reviews</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        test
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->


        </div>
    </div>


    </div>
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
