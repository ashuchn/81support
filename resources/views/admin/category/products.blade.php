@extends('admin.layout.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Showing Products in <b>{{ !empty($category[0]) ? $category[0] : '' }}</b>
                            Category</h1>
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
            <div class="col-12 mx-auto">
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
                                    <div id="carouselExampleControls<?php echo $i; ?>" class="carousel slide"
                                        data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            $active = true;
                                            ?>
                                            @foreach ($item->images as $img)
                                                <div class="carousel-item <?php if ($active == true) {
                                                    echo 'active';
                                                } ?>">
                                                    <img class="img-fluid card-img-top img-thumbnai"
                                                        src="{{ $img }}"
                                                        style="max-height: 300px; max-width: 400px;" alt="First slide">
                                                    <div class="card-img-overla">

                                                    </div>
                                                </div>
                                                <?php $active = false; ?>
                                            @endforeach

                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $i; ?>"
                                            role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls<?php echo $i; ?>"
                                            role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
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
                <div class="d-flex justify-content-end">
                    {{ $data->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
