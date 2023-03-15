@extends('admin.layout.layout')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endsection

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
                                            <a href="{{ $item->images[0] }}"
                                                data-toggle="lightbox" data-title="{{ $item->productName }}" data-gallery="gallery">
                                                <img style="width: 150px; height: auto; object-fit: cover;"
                                                    src="{{ $item->images[0] }}" alt="image">
                                            </a>
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

@section('script')
    <!-- Ekko Lightbox -->
    <script src="{{ url('assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
@endsection
