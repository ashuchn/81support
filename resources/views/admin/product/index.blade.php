@extends('admin.layout.layout')

@section('title', 'Product Management')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">

            @if (session()->has('success'))
                <div class="alert alert-success p-2 alert-dismissable">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="col-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><a href="{{ route('product.create') }}"><button type="button"
                                    class="btn btn-block bg-gradient-primary">Add Product</button></a></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Features</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php $i = 1; ?>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>
                                            <img style="width: 80px; height: 150px; object-fit: cover;" src="{{ $item->images[0] }}" alt="image">
                                        </td>
                                        <td>{{ $item->productName }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <div class="container">
                                                <span class="fa fa-star checked"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-light">Details</a>
                                            <button class="btn btn-light">Edit</button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    No record Found
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Features</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $data->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
