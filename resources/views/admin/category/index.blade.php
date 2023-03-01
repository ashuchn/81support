@extends('admin.layout.layout')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
  {{-- <link rel="stylesheet" href="{{url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"> --}}
  {{-- <link rel="stylesheet" href=""> --}}
  <link rel="stylesheet" href="{{url('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mx-auto">

                        @if(session()->has('success'))
                        <div class="alert alert-success p-2">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header"><a href="{{ route('category.create') }}" class="btn btn-success float-right btn-sm"><i class="fas fa-plus fa-xs"></i> Add New</a></div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Products</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1 @endphp
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td style="width: 50%">{{ $item->categoryName }}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{ route('category.show', ['category' => $item->id]) }}">View Products</a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('category.destroy', ['category' => $item->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="btn btn-danger" title="Delete" data-toggle="tooltip" onclick="this.closest('form').submit();return false;">Delete</a>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
@endsection
