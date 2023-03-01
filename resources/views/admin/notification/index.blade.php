@extends('admin.layout.layout')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('title', 'Send Notifcation')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Notifications</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Notifications</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mx-auto">

                        @if (session()->has('success'))
                            <div class="alert alert-success p-2">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        <div class="card">
                            {{-- <div class="card-header">
                                <a href="{{ route('category.create') }}" class="btn btn-success float-right btn-sm"><i class="fas fa-plus fa-xs"></i> Add New</a>
                            </div> --}}
                            <div class="card-body">
                                <button class="btn-light btn" onclick="selectAll()">Select All</button>
                                <button class="btn-light btn" onclick="deselectAll()">Deselect All</button>
                                <form action="{{ route('admin.sendNotification') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12 col-lg-12">
                                            <label for="">Choose Users: <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="users[]"
                                                data-placeholder="Choose Users" multiple="multiple">
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                                </option>
                                            </select>
                                            @error('users')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="">Category: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="category" data-placeholder="Choose Category">
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="image">Image <span class="text-danger">*</span></label>
                                            <input type="file" name="image" class="form-control">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 col-lg-12">
                                            <label for="">Title: <span class="text-danger">*</span></label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="Title">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 col-lg-12">
                                            <label for="">Message: <span class="text-danger">*</span></label>
                                            <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                            @error('message')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary" value="Send">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')

    <script src="{{ url('assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        })

        function selectAll() {
            $(".select2 > option").prop("selected", true);
            $(".select2").trigger("change");
        }

        function deselectAll() {
            $(".select2 > option").prop("selected", false);
            $(".select2").trigger("change");
        }
    </script>
@endsection
