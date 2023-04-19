@extends('subadmin.layout.layout')
@section('title', 'Add Product Size Quantity')
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

                <form action="{{ route('subadmin.products.store') }}" role="form" id="quickForm" class="card"
                    method="post" enctype="multipart/form-data">
                    @csrf
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
                                    <input type="number" name="price"
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
                            <div class="col-lg-8">
                                <div class="col-12 d-flex justify-content-center">
                                    <button class="ms-auto btn btn-outline-primary add-more">Add Color</button>
                                </div>
                                <hr>
                                <div id="ColorsSizeItem"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table">
                                            <thead>
                                                <th>Color</th>
                                                <th>Images</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="col-12">
                                                            <select name="colors[]" class="form-select select2" required>
                                                                <option value="">Choose Color</option>
                                                                @foreach ($colors as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('colors')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="file" name="images[]"
                                                                class="form-control @error('image') ? ' is-invalid' : '' @enderror"
                                                                placeholder="Enter Quantity" multiple required>
                                                            @error('images')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table">
                                            <thead>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        XS
                                                        <input name="sizes[]" type="number" value="1" class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                                                        <input name="sizes[]" type="number" value="2" class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                                                        <input name="sizes[]" type="number" value="3"
                                                            class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                                                        <input name="sizes[]" type="number" value="4"
                                                            class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                                                        <input name="sizes[]" type="number" value="5"
                                                            class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                                                        <input name="sizes[]" type="number" value="6"
                                                            class="d-none">
                                                    </td>
                                                    <td>
                                                        <div class="col-12">
                                                            <input type="number" name="quantity[]"
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
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
            $(".add-more").click(function(e) {
                e.preventDefault();
                $("#ColorsSizeItem").prepend(`

                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table">
                                <thead>
                                    <th>Color</th>
                                    <th>Images</th>
                                    <th>
                                        <button style="padding: 4px 9.5px;" class="d-lg-none text-center float-end btn btn-sm rounded-circle btn-danger remove">
                                            <b>X</b>    
                                        </button>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="col-12">
                                                <select name="colors[]" class="form-select select2" required>
                                                    <option value="">Choose Color</option>
                                                    @foreach ($colors as $item)
                                                         <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('colors')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="file" name="images[]"
                                                    class="form-control @error('image') ? ' is-invalid' : '' @enderror"
                                                    placeholder="Enter Quantity" multiple required>
                                                @error('images')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table">
                                <thead>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>
                                        <button style="padding: 4px 9.5px;" class="d-none d-lg-block text-center float-end btn btn-sm rounded-circle btn-danger remove">
                                            <b>X</b>    
                                        </button>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            XS
                                            <input name="sizes[]" type="number" value="1" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                                            <input name="sizes[]" type="number" value="2" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                                            <input name="sizes[]" type="number" value="3" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                                            <input name="sizes[]" type="number" value="4" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                                            <input name="sizes[]" type="number" value="5" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                                            <input name="sizes[]" type="number" value="6" class="d-none">
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12">
                                                <input type="number" name="quantity[]"
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
                        <hr>
                    </div>
                                   
                `);
            });

            $(document).on('click', '.remove', function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection
