@extends('subadmin.layout.layout')
@section('title', 'product detail')
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{ isset($product->productName) ? $product->productName : '' }}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">81 Support</li>
                                    <li class="breadcrumb-item active">
                                        {{ isset($product->productName) ? $product->productName : '' }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>


                <form action="{{ route('subadmin.products.update', ['product' => $product->id]) }}" role="form"
                    id="quickForm" class="card" method="patch" enctype="multipart/form-data">
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
                                        value="{{ isset($product->productName) ? $product->productName : old('productName') }}"
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
                                        value="{{ isset($product->price) ? $product->price : old('price') }}"
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
                                            <option value="{{ $item->id }}"
                                                @php if($item->id == $product->categoryId) { echo 'selected'; } @endphp>
                                                {{ $item->categoryName }}</option>
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
                                            rows="10" placeholder="Product Description..." required>{{ isset($product->description) ? $product->description : old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="col-12">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="button" class="ms-auto btn btn-outline-primary add-more" data-bs-toggle="modal" data-bs-target="#myModal">Add Color</button>
                                    </div>

                                    <!-- sample modal content -->
                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel">Add More Color Variants</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button class="ms-auto btn btn-outline-primary add-more">Add
                                                            More</button>
                                                    </div>
                                                    <div id="ColorsSizeItem"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light">Save
                                                        changes</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                                @php $i=0 @endphp
                                @foreach ($rows as $item)
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
                                                                <select name="colors[]" class="form-select select2"
                                                                    required>
                                                                    <option value="">Choose Color</option>
                                                                    <option
                                                                        @if ($colors[$i]->color == '1') selected @endif
                                                                        value="1">Red</option>
                                                                    <option
                                                                        @if ($colors[$i]->color == '2') selected @endif
                                                                        value="2">Blue</option>
                                                                    <option
                                                                        @if ($colors[$i]->color == '3') selected @endif
                                                                        value="3">Green</option>
                                                                    <option
                                                                        @if ($colors[$i]->color == '4') selected @endif
                                                                        value="4">Yellow</option>
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
                                                    @foreach ($item as $key => $value)
                                                        <tr>
                                                            <td>
                                                                {{ $value->size }}
                                                                <input name="sizes[]" type="text"
                                                                    value="{{ $value->size }}" class="d-none">
                                                            </td>
                                                            <td>
                                                                <div class="col-12">
                                                                    <input type="number" name="quantity[]"
                                                                        class="form-control @error('quantity') ? ' is-invalid' : '' @enderror"
                                                                        value="{{ $value->quantity }}"
                                                                        placeholder="Enter Quantity"
                                                                        value="{{ $value->quantity }}" required>
                                                                    @error('quantity')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
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
    <script>
        $(document).ready(function() {
            $(".add-more").click(function(e) {
                e.preventDefault();
                $("#ColorsSizeItem").prepend(`

                    <div class="row">
                        <div class="col-12">
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
                                                    <option value="1">Red</option>
                                                    <option value="2">Blue</option>
                                                    <option value="3">Green</option>
                                                    <option value="4">Yellow</option>
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
                        <div class="col-12">
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
                                            <input name="sizes[]" type="text" value="XS" class="d-none">
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
                                            <input name="sizes[]" type="text" value="S" class="d-none">
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
                                            <input name="sizes[]" type="text" value="M" class="d-none">
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
                                            <input name="sizes[]" type="text" value="L" class="d-none">
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
                                            <input name="sizes[]" type="text" value="XL" class="d-none">
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
                                            <input name="sizes[]" type="text" value="XXL" class="d-none">
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
