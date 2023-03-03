@extends('subadmin.layout.layout')
@section('title', 'Add Product')
@section('css')
    <link rel="stylesheet" href="{{ url('assets/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="main-content">
        <!-- Main content -->
        <section class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"></h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">81 Support</li>
                                    <li class="breadcrumb-item active">Add Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('subadmin.products.store') }}" role="form" id="quickForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1">Product Name</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="productName" class="form-control @error('productName') ? ' is-invalid' : '' @enderror" placeholder="Enter Product Name" required>
                                            @error('productName')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="price">Price (in $)</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="price" class="form-control @error('price') ? ' is-invalid' : '' @enderror" placeholder="Enter Product Price" required>
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="price">Description</label>
                                            <span class="text-danger">*</span>
                                            <textarea class="form-control @error('description') ? ' is-invalid' : '' @enderror" name="description" cols="30" rows="10" placeholder="Product Description..." required></textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1">Images</label>
                                            <input type="file" name="images[]" class="form-control" aria-required="" multiple required>
                                            @error('images')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Choose Category:</label>
                                            <span class="text-danger">*</span>
                                            <select name="category" class="form-select select2" required>
                                                <option value="">Choose Category</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->categoryName }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Quantity:</label>
                                            <span class="text-danger">*</span>
                                            <input type="number" name="available_quantity" class="form-control @error('quantity') ? ' is-invalid' : '' @enderror" placeholder="Enter Product Quantity" required>
                                            @error('available_quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


@endsection
@section('script')

<script src="{{ url('assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $('.select2').select2({
    theme: 'bootstrap4',
    dropdownAutoWidth : true
  })

</script>
@endsection