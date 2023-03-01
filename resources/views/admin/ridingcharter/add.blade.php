@extends('admin.layout.layout')
@section('title', 'Add Riding Charter')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Riding Charter </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Riding Charter </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	@if ($errors->any())
	<div class="card-body">
	<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	@foreach ($errors->all() as $error)
	<p>{{ $error }}</p>
	@endforeach

	</div>


	</div>

	@endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('ridingcharter.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Shop Name</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                  </div>
				  
				          <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" class="form-control"  placeholder="Enter Email" required>
                  </div>
				  
				          <div class="form-group">
                    <label for="exampleInputEmail1">Mobile</label>
                    <span class="text-danger">*</span>
                    <input type="number" name="mobile" class="form-control"  placeholder="Enter Mobile" required>
                  </div>
				  
				        <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" name="password" class="form-control"  placeholder="Enter Password" required>
                  </div>

                  <div class="form-group">
                    <div class="form-group">
                      <label for="">Enter Location:</label>
                    <span class="text-danger">*</span>
                      <input type="text" name="autocomplete" id="autocomplete" class="form-control" required>
                  </div>
                  <div class="form-group" id="latitudeArea">
                      <label for="">Latitude</label>
                    <span class="text-danger">*</span>
                      <input type="text" name="latitude" id="latitude" class="form-control" required>
                  </div>
                  <div class="form-group" id="longitudeArea">
                      <label for="">Longitude</label>
                    <span class="text-danger">*</span>
                      <input type="text" name="longitude" id="longitude" class="form-control" required>
                  </div>
                  </div>
				
                  <div class="form-group">
                    <label for="exampleInputFile">Profile Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
				 
				  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
  
  
  @endsection
  @section('script')

  <script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}&libraries=places&callback=Function.prototype"></script>
  <script>
      function gmNoop() { console.log('GMap Callback') }
  </script>
  <script>
      $(document).ready(function () {
          $('#latitudeArea').addClass('d-none');
          $('#longitudeArea').addClass('d-none');
      });
  </script>
  <script>
      google.maps.event.addDomListener(window, 'load', initialize);

      function initialize() {
          let input = document.getElementById('autocomplete');
          let autocomplete = new google.maps.places.Autocomplete(input);

          autocomplete.addListener('place_changed', function() {
              let place = autocomplete.getPlace();
              console.log(place);
              $('#latitude').val(place.geometry['location'].lat);
              $('#longitude').val(place.geometry['location'].lng);

              $('#latitudeArea').removeClass('d-none')
              $('#longitudeArea').removeClass('d-none')
          });
      }
  </script>

  @endsection
