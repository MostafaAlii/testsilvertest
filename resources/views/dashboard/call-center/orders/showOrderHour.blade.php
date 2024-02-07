@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection
@section('title')
{{ucfirst($order?->order_code)}}
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> {{ucfirst($order?->order_code)}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('callCenter.dashboard')}}" class="default-color">Dasboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('CallCenterCaptains.index')}}" class="default-color">Captains</a>
                </li>
                <li class="breadcrumb-item active">{{ucfirst($order?->order_code)}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@include('layouts.common.partials.messages')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="shadow accordion plus-icon">
                    <div class="acd-group">
                        <a href="#" class="acd-heading">Order Details - Code ( {{ucfirst($order?->order_code)}} )</a>
                        <div class="acd-des">
                            <div>
                                <div class="col-12 d-flex">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-7 mb-30">
                                                <div id="map" style="width:100%;height:400px;"></div>
                                            </div>
                                            <div class="col-xl-5 mb-30" style="font-weight: bold;">
                                                <p class="mb-0">Client: {{ucfirst($order?->user?->name)}}</p>
                                                <p class="mb-0">Captain: {{ucfirst($order?->captain?->name)}}</p>
                                                <p class="mb-0">Trip Type: {{ucfirst($order?->trip_type?->name)}}</p>
                                                <p class="mb-0">Price: {{ucfirst($order?->total_price)}}</p>
                                                <p class="mb-0">From: <span class="text-danger" id="fromAddress"></span>
                                                </p>
                                                <p class="mb-0">Status: {{ucfirst($order?->status())}}</p>
                                                <p class="mb-0">Price Status: {{ucfirst($order?->status_price)}}</p>
                                                <p class="mb-0">Type Duration: {{ucfirst($order?->type_duration)}}</p>
                                                <p class="mb-0">Time Duration: {{ucfirst($order?->time_duration)}}</p>
                                                <p class="mb-0">Hours From: {{ucfirst($order?->hours_from)}}</p>
                                                <p class="mb-0">Payment: {{ !empty($order?->payments) ?
                                                    ucfirst($order?->payments) : ucfirst('No Payment For This Order') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Chat -->
                    <div class="col-12 d-flex">
                        <div class="card-body">
                            <!-- Start Chat Widget -->
                            <div class="chats-topbar mb-30 position-relative">
                                <div class="d-block d-md-flex justify-content-between">
                                    <div class="d-block">
                                        <h6 class="mb-0">{{ucfirst($order?->user?->name) . ' / ' .
                                            ucfirst($order?->captain?->name) . ' Chat'}}</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- End Chat Widget -->
                            <!-- Start Chat ScrollBar -->
                            <div class="scrollbar max-h-600"
                                style="height: 300px; overflow-y: scroll; overflow-x: scroll;">
                                <div class="chats">
                                    <div class="chat-wrapper clearfix">
                                        <div class="chat-avatar">
                                            <img class="img-fluid avatar-small"
                                                src="https://themes.potenzaglobalsolutions.com/html/webmin-bootstrap-4-angular-12-admin-dashboard-template/html/images/team/05.jpg"
                                                alt="">
                                        </div>
                                        <div class="chat-body p-3">
                                            <p>So, make the decision to move forward. Commit your decision to paper just
                                                to bring.</p>
                                        </div>
                                    </div>
                                    <div class="chat-wrapper chat-me clearfix">
                                        <div class="chat-avatar" style="float: right !important;">
                                            <img class="img-fluid avatar-small pull-left"
                                                src="https://themes.potenzaglobalsolutions.com/html/webmin-bootstrap-4-angular-12-admin-dashboard-template/html/images/team/06.jpg"
                                                alt="">
                                        </div>
                                        <div class="chat-body p-3 mr-5">
                                            <p>Having clarity of purpose and a clear picture of what you.</p>
                                        </div>
                                    </div>
                                    <span class="time d-block mt-20px mb-20 text-center text-gray">3:15PM </span>

                                    <div class="chat-wrapper clearfix">
                                        <div class="chat-avatar">
                                            <img class="img-fluid avatar-small"
                                                src="https://themes.potenzaglobalsolutions.com/html/webmin-bootstrap-4-angular-12-admin-dashboard-template/html/images/team/05.jpg"
                                                alt="">
                                        </div>
                                        <div class="chat-body p-3">
                                            <p>So, make the decision to move forward. Commit your decision to paper just
                                                to bring.</p>
                                        </div>
                                    </div>
                                    <div class="chat-wrapper chat-me clearfix">
                                        <div class="chat-avatar" style="float: right !important;">
                                            <img class="img-fluid avatar-small pull-left"
                                                src="https://themes.potenzaglobalsolutions.com/html/webmin-bootstrap-4-angular-12-admin-dashboard-template/html/images/team/06.jpg"
                                                alt="">
                                        </div>
                                        <div class="chat-body p-3 mr-5">
                                            <p>Having clarity of purpose and a clear picture of what you.</p>
                                        </div>
                                    </div>
                                    <span class="time d-block mt-20px mb-20 text-center text-gray">3:15PM </span>
                                </div>
                            </div>
                            <!-- End Chat ScrollBar -->
                        </div>
                    </div>
                    <!-- End Chat -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function initializeMap() {
        const locations = {!! $data !!};
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: { lat: locations[locations.length - 1].lat, lng: locations[locations.length - 1].lng },
        });
        const infowindow = new google.maps.InfoWindow();
        const bounds = new google.maps.LatLngBounds();
        for (const location of locations) {
            const marker = new google.maps.Marker({
                position: new google.maps.LatLng(location.lat, location.lng),
                map: map,
                icon: {
                    url: location.image,
                    scaledSize: new google.maps.Size(32, 32)
                }
            });
            const geocoder = new google.maps.Geocoder();
            const latLng = new google.maps.LatLng(location.lat, location.lng);
            geocoder.geocode({ 'location': latLng }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        const content = results[0].formatted_address;
                        document.getElementById("fromAddress").innerHTML = content;
                        google.maps.event.addListener(marker, 'click', (function (marker, location) {
                            return function () {
                                infowindow.setContent(content);
                                infowindow.open(map, marker);
                            };
                        })(marker, location));
                    }
                }
            });
            bounds.extend(marker.position);
        }
        map.fitBounds(bounds);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeMap();
    });
</script>
<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initializeMap"></script>
@endsection