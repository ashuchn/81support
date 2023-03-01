@extends('admin.layout.layout')
@section('content')

<?php $content_type=array("about_us"=>"About Us","contact_us"=>"Contact Us","terms_and_conditions"=>"Terms and Conditions","privacy_policy"=>"Privacy Policy")?>


<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
            
              
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo  $content_type[$info->type]." Content"; ?> </li>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
			<?php echo $content_type[$info->type]." Content"; ?>
              
            </h3>
              <div class="card-tools">
				<a href="javascript:void()" data-toggle="modal" data-target="#profile" ><i class="fa fa-edit"></i></a>
				</div>
          </div>
          <div class="card-body">
            <h4></h4>


<section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default " >
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
			
              <div class="col-md-6">
                <div class="form-group">
                  <p><label>Content Type</label></p>
                  <p><?php echo $content_type[$info->type]; ?></p>
                </div>
              </div>
                
                <div class="col-md-6">
                <div class="form-group">
                  <p><label>Last Modify Date</label></p>
                  <p><?php echo $info->updated_at; ?></p>
                  <p></p>
                </div>
              </div>
              </div>
			 <div class="row">
			  <div class="col-md-12">
                <div class="form-group">
                  <p><label>Content</label></p>
                  <p><?php echo $info->information; ?></p>
                </div>
              </div>
    
            </div>
           
          </div>
          <!-- /.card-body -->
         
		  
        </div>
       
        <!-- /.row -->
      </div>
	  
    </section>
	
			
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
		
		
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

 <div class="modal fade" id="profile">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update <?php echo $content_type[$info->type]." Content"; ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
			 
			 
        <!-- SELECT2 EXAMPLE -->
          <form action="{{route('admin.update_static_content')}}" method="post">
                @csrf
            <div class="row">
<!--
              <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Content Type</label><br>
                      <select class="form-select" aria-label="Default select example" name="type"  id="type">
                          
                        <option selected>Select Content Type</option>

                        <option value="about_us">About Us</option>
                        <option value="contact_us">Contact Us</option>
                        <option value="terms_and_conditions">Terms and Conditions</option>
                        <option value="privacy_policy">Privacy Policy</option>
                    </select>
                  </div>
			  </div>
-->
			   <div class="col-md-12">
                <div class="form-group">
                    <label for="data" class="form-label">Content</label>
                    <textarea class="form-control" id="data" name="data" rows="20" ><?php echo $info->information; ?></textarea>
                  </div>
			  </div>

              </div>
             <input type="hidden" class="form-control" name="static_content_id" id="exampleInputEmail1" value="<?php echo $info->id; ?>">
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
			
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	 </div> 
	
					<script>
					$(document).ready(function(){
					$("#document").change(function(){
					var DocumentVal = $('#document').val();
					if(DocumentVal=='Rejected'){
						$('#modal-reject-document').modal('show');
					}
					});
					});
					</script>
					
					<script>
					$(document).ready(function(){
					$("#Others").click(function(){
					$("#rejection-text").css('display', 'block');
					});

					});
					
					
					</script>
	


  @endsection