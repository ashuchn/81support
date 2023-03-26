@extends('admin.layout.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
  {{-- <link rel="stylesheet" href="{{url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"> --}}
  {{-- <link rel="stylesheet" href=""> --}}
  <link rel="stylesheet" href="{{url('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection

@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Static Content</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Static Content</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	@if (session('success'))
	<div class="card-body">
	<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5>{{ Session::get('success') }}</h5>
	<?php Session::forget('success');?>
	</div>
    </div>
	@endif
	
	
	
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="{{route('admin.add_static_content')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Static Content</button></a></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive-sm">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Content Type</th>
                    <th>Content</th>
                    <th>Last Modify Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($static_content as $key => $static_content_Details)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$static_content_Details->type}}</td>
                      <td class="mh-10"> <div class="mh-10">{{$static_content_Details->information}}</div>
					</td>
					<td>@if(empty($static_content_Details->updated_at))
                            {{$static_content_Details->created_at}}
                        @else
                            {{$static_content_Details->updated_at}}
                        @endif
                      </td>
                    <td>
						 
                        
                        <a href="{{ route('admin.view_static_content', ['id' =>$static_content_Details->id ]) }}">
						<button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
						<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#modal-delete<?php echo $static_content_Details->id; ?>"><i class="fa fa-trash"></i></button>
						

					  </td>
                  </tr>
				  
				  
				  <div class="modal fade" id="modal-delete<?php echo $static_content_Details->id; ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Alert</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are You Sure You Want To Delete This Item ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              <a href="{{ route('admin.destroy_static_content', ['id' =>$static_content_Details->id ]) }}"><button type="button" class="btn btn-primary">Yes</button></a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
				  
				  @endforeach	
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
			
			
			
			
			
			
			
			
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
	
	
  
  
   </div>
  @endsection
@section('script')
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example1').DataTable();
});
</script>
@endsection