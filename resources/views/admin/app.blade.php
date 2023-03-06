@extends('admin.layout.layout')
@section('content')
    {{-- put all the content inside content-wrapper class --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $users }}</h3>

                                <p>Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('user.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $ridingCharter }}<sup style="font-size: 20px"></sup></h3>

                                <p>Riding Charters</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('ridingcharter.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $products }}</h3>

                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $categories }}</h3>

                                <p>Categories</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('category.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row p-2 pt-0">
                    <div class="p-2 px-0">
                        <h1>Our Riding Charters</h1>
                    </div>
                    <div id="map" style="height: 500px; width: 100%;"></div>
                </div>
            </div> <!-- container fluid ends -->
        </div>
    </div>

    <script type="text/javascript">
        function initializeMap() {
            const myLatLng = {
                lat: 22.2734719,
                lng: 70.7512559
            };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 5,
                center: myLatLng,
            });
            var locations = {{ Js::from($locations) }};
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            var bounds = new google.maps.LatLngBounds();
            for (var location of locations) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.latitude, location.longitude),
                    map: map
                });
                bounds.extend(marker.position);
                google.maps.event.addListener(marker, 'click', (function(marker, location) {
                    return function() {
                        infowindow.setContent(location.name);
                        infowindow.open(map, marker);
                    }
                })(marker, location));
    
            }
            map.fitBounds(bounds);
        }
        window.initializeMap = initializeMap;
    </script>

    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}&callback=initializeMap"></script>
@endsection
