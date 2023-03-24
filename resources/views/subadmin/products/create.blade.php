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

                <form class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Product</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-12 mb-3">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="productName"
                                        class="form-control @error('productName') ? ' is-invalid' : '' @enderror"
                                        placeholder="Enter Product Name" required>
                                    @error('productName')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="price">Price (in $)</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="price"
                                        class="form-control @error('price') ? ' is-invalid' : '' @enderror"
                                        placeholder="Enter Product Price" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
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
                                <div class="form-group col-12 mb-3">
                                    <div class="col-md-12">
                                        <label for="price">Description</label>
                                        <span class="text-danger">*</span>
                                        <textarea class="form-control @error('description') ? ' is-invalid' : '' @enderror" name="description" cols="30"
                                            rows="10" placeholder="Product Description..." required></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="color">Product Colors</label>
                            </div>
                            <div class="col-lg-4">
                                <div class="row border border-2 rounded" id="ColorsSizeItem">
                                    <div class="col-2">
                                        <table class="table">
                                            <thead>
                                                <th>Color</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="color" name="color" id="color"
                                                            placeholder="Enter Last Name"
                                                            class="form-control @error('color') is-invalid @enderror p-0 mx-auto rounded"
                                                            value="{{ old('color') }}" style="height: 40px; width: 100%;">
                                                        @error('color')
                                                            <p class="invalid-feedback">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-10">
                                        <table class="table">
                                            <thead>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        XS
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        S
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        M
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        L
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        XL
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        XXL
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row border border-2 rounded" id="ColorsSizeItem">
                                    <div class="col-2">
                                        <table class="table">
                                            <thead>
                                                <th>Color</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="color" name="color" id="color"
                                                            placeholder="Enter Last Name"
                                                            class="form-control @error('color') is-invalid @enderror p-0 mx-auto rounded"
                                                            value="{{ old('color') }}" style="height: 40px; width: 100%;">
                                                        @error('color')
                                                            <p class="invalid-feedback">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-10">
                                        <table class="table">
                                            <thead>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        XS
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        S
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        M
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        L
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        XL
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        XXL
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="text" name="quantity"
                                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" required>
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
                            <form action="{{ route('subadmin.products.store') }}" role="form" id="quickForm"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1">Product Name</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="productName"
                                                class="form-control @error('productName') ? ' is-invalid' : '' @enderror"
                                                placeholder="Enter Product Name" required>
                                            @error('productName')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="price">Price (in $)</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="price"
                                                class="form-control @error('price') ? ' is-invalid' : '' @enderror"
                                                placeholder="Enter Product Price" required>
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="price">Description</label>
                                            <span class="text-danger">*</span>
                                            <textarea class="form-control @error('description') ? ' is-invalid' : '' @enderror" name="description"
                                                cols="30" rows="10" placeholder="Product Description..." required></textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1">Images</label>
                                            <input type="file" name="images[]" class="form-control" aria-required=""
                                                multiple required>
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
                                                    <option value="{{ $item->id }}">{{ $item->categoryName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Quantity:</label>
                                            <span class="text-danger">*</span>
                                            <input type="number" name="available_quantity"
                                                class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                placeholder="Enter Product Quantity" required>
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
            dropdownAutoWidth: true
        })
    </script>

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
