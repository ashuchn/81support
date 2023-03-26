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
                            <h4 class="mb-sm-0">Products</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">81 Support</li>
                                    <li class="breadcrumb-item active">Products</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="p-2">
                                            <h3 class="card-title"><a href="{{ route('subadmin.products.create') }}"><button
                                                        type="button"
                                                        class="btn btn-block bg-gradient-primary  btn-primary">Add
                                                        Product</button></a></h3>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="d-flex justify-content-end">
                                            <div class="p-2 ">
                                                <select name="category" id="category" class="form-select">
                                                    <option value="">Filter Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>price</th>
                                            <th>Quantity</th>
                                            <th>description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->categoryName }}</td>
                                                <td style="width:300px">{{ $item->productName }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->available_quantity }}</td>
                                                <td style="width:600px">
                                                    {{ $item->description }}
                                                </td>
                                                <td class="d-flex">
                                                    <a href="{{ route('subadmin.products.show', $item->id) }}">
                                                        <button type="button" class="btn btn-primary"><i
                                                                class="fa fa-eye"></i></button>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('subadmin.products.destroy', ['product' => $item->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="btn btn-danger" title="Delete"
                                                            data-toggle="tooltip"
                                                            onclick="this.closest('form').submit();return false;"><i
                                                                class="fa fa-trash"></i></a>
                                                        {{-- <button type="button" class="btn btn-danger"></button> --}}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $data->links() }}
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


        </div>
    </div>


    </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                "paging": false
            });
        });
    </script>
@endsection
