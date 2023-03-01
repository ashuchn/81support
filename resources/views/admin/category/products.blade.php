@extends('admin.layout.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Showing Products in <b>{{ !empty($category[0]) ? $category[0] : '' }}</b> Category</h1>
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
            <div class="container-fluid">
                {{-- <button "></button> --}}
                <div class="row">
                    <?php $i = 1; ?>
                      @forelse($data as $item)
                      
                        <!-- <div class="col-sm-12 col-md-6 col-lg-4 col-lg-2 mb-4"> -->
                        <div class="col-sm-12  mb-4">
                        <div class="card">
                            <!-- <img class="card-img-top" src="" alt="Card image cap"> -->
                            <div class="row">
                                    <div class="col-md-4">
                                          <div id="carouselExampleControls<?php echo $i ?>" class="carousel slide" data-ride="carousel">
                                              <div class="carousel-inner">
                                                <?php
                                                  $active = TRUE;
                                                ?>
                                                @foreach($item->images as $img)
                                                    <div class="carousel-item <?php if($active == TRUE) { echo "active" ;} ?>">
                                                      <img class="img-fluid card-img-top img-thumbnail" src="{{ $img }}" style="height: 30%" alt="First slide">
                                                      <div class="card-img-overlay">
                                                            
                                                      </div>
                                                    </div>
                                                    <?php  $active = FALSE; ?>
                                                @endforeach
                                                    
                                              </div>
                                              <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $i ?>" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                              </a>
                                              <a class="carousel-control-next" href="#carouselExampleControls<?php echo $i ?>" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                              </a>
                                          </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                           
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <h5 class="card-title pb-2">
                                                        <b>{{ $item->productName }}</b>
                                                      </h5>
                                                  </div>     
                                              </div>
                                              
                                              
                                            
                                            {{-- <p class="card-text"><small class="text-muted">{{ $hotel['propertyDetails']['address']['fullAddress'] }}</small></p> --}}
                                            <p class="card-text"><small class="text-muted"></small></p>
                                            <hr class="hr hr-blurry" />
                                            <div class="container">
                                                  <span class="fa fa-star checked"></span>
                                                  {{-- {{ $hotel['propertyDetails']['starRatingTitle'] }} --}}
                                            </div>
                                            <h6>Features:</h6>
                                            <p class="card-text">
                                                {{ $item->description }}
                                                {{-- @foreach($hotel['ameneties'][0]['content'] as $features)
                                                    <button class="btn btn-outline-light text-dark shadow-none rounded-pill" style=" height: 30px;">{{ $features }}</button>
                                                @endforeach --}}
                                                <?php 
                                                  //for($x = 0; $x < count())
                                                ?>
                                            </p>
                                                <a href="#" class="btn btn-light">Details</a>
                                                <button class="btn btn-light">Edit</button>
                                        </div>
                                    </div>
                            </div>
                            
                              
                        </div>
                        </div><!-- col ends -->
                        <?php $i++; ?>
                        @empty
                        No record Found
                      @endforelse
                        
                    </div> <!-- row ends -->
            </div>
            <div class="d-flex justify-content-end">
              {{ $data->links() }}
          </div>
        </section>
    </div>
@endsection
