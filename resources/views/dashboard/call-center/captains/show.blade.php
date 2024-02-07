@extends('layouts.master')
@section('css')
@section('title')
{{ $data['captain']->name . ' ' . $data['title'] }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ $data['captain']->name . ' ' . $data['title'] }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">Dasboard</a></li>
                <li class="breadcrumb-item active">{{ $data['captain']->name . ' ' . $data['title'] }}</li>
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
                <div class="row">
                    <div class="col-md-6">
                        <h2>{{ $data['captain']->name }} Information</h2>
                        <p>Name: {{ $data['captain']->name }}</p>
                        <p>Email: {{ $data['captain']->email }}</p>
                        <p>Phone: {{ $data['captain']->phone }}</p>
                    </div>

                    <div class="col-md-6">
                        <h2>Profile Information</h2>
                        <p>Address: {{ $data['captain']->profile->address }}</p>
                        <p>Bio: {{ $data['captain']->profile->bio }}</p>
                        <p>Rate: {{ $data['captain']->profile->rate }}</p>
                        <p>Number of Trips: {{ $data['captain']->profile->number_trips }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 text-left align-self-center">
                        <form id="toggleForm{{ $data['captain']->id }}" method="POST"
                            action="{{ route('CallCenterCaptains.updateActivityStatus',$data['captain']?->id) }}">
                            @csrf
                            @method('PUT')
                            <label>Captain Work Status</label>
                            <select class="form-control p-2" name="status_captain_work" style="outline-style:none;"
                                onchange="this.form.submit();">
                                <option selected>Choose Captain Work Status</option>
                                <option value="active" {{$data['captain']?->captainActivity?->status_captain_work ==
                                    'active' ? 'selected' : ''}}>Active</option>
                                <option value="waiting" {{$data['captain']?->captainActivity?->status_captain_work ==
                                    'waiting' ? 'selected' : ''}}>Waiting</option>
                            </select>
                        </form>
                        <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                            data-target="#blockCaptainModal">
                            Block Captain
                        </button>
                        @php
                        $blocks = DB::table('captain_callcenter_blocks')
                        ->join('callcenters', 'captain_callcenter_blocks.call_center_id', '=', 'callcenters.id')
                        ->where('captain_callcenter_blocks.captain_id', $data['captain']->id)
                        ->select('captain_callcenter_blocks.*', 'callcenters.name AS call_center_name')
                        ->get();
                        @endphp

                        @if ($data['captain']?->captainActivity?->status_captain_work == 'block')
                        <button type="button" class="btn btn-warning mt-2" data-toggle="modal"
                            data-target="#showBlockCaptainModal">
                            Show Blocks
                        </button>
                        @endif
                        <button type="button" class="btn btn-success mt-2" data-toggle="modal"
                            data-target="#addProfileDetail{{$data['captain']?->id}}">
                            Add Profile Details
                        </button>
                        @if($data['captain']?->captainActivity?->status_captain_work == 'block')
                        @php
                        $blockReason = DB::table('captain_callcenter_blocks')->where('captain_id',
                        $data['captain']->id)->value('block_reason');
                        @endphp

                        @if ($blockReason)
                        <div class="mt-2">
                            <strong>Captain is Blocked:</strong> {{$blockReason}}
                        </div>
                        @else
                        <div class="mt-2">
                            <strong>Captain is Blocked, but block reason is not available.</strong>
                        </div>
                        @endif
                        @endif
                        <!-- Block Modal -->
                        @include('dashboard.call-center.captains.btn.modals.profile.block')
                        @include('dashboard.call-center.captains.btn.modals.profile.blockDetails')
                        @include('dashboard.call-center.captains.btn.modals.profile.details')
                        @include('dashboard.call-center.captains.btn.modals.profile.addCar')
                        <!-- End Block Modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->

<!-- Start Content and Tabs -->
<div class="row">
    <!-- Start Tabs -->
    <div class="col-xl-12 col-lg-12 mb-30">
        <div class="card mb-30">
            <div class="card-body">
                <div class="comment-block">
                    <div class="mb-0 form-group">
                        <div class="tab nav-bt">
                            <!-- Start Nav Tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    @if ($data['captain']->status_caption_type == 'car')
                                    <a class="nav-link active show" id="profile-03-tab" data-toggle="tab"
                                        href="#profile-03" role="tab" aria-controls="profile-03"
                                        aria-selected="true">Profile</a>
                                </li>
                                @endif
                                @if ($data['captain']->status_caption_type == 'scooter')
                                    <li class="nav-item">
                                        <a class="nav-link" id="scooter-tab" data-toggle="tab" href="#scooter" role="tab"
                                            aria-controls="scooter" aria-selected="true">Scooter</a>
                                    </li>
                                @endif
                                @if ($data['captain']->status_caption_type == 'tricycle')
                                    <li class="nav-item">
                                        <a class="nav-link" id="tricycle-tab" data-toggle="tab" href="#tricycle" role="tab"
                                            aria-controls="tricycle" aria-selected="true">Tricycle</a>
                                    </li>
                                @endif
                                
                            </ul>
                            <!-- End Nav Tabs -->

                            <!-- Start Tab Content -->
                            <div class="tab-content">
                                @includeWhen($data['captain']->status_caption_type == 'car','dashboard.call-center.captains.tabs.profile.profile_content_tab')
                                @includeWhen($data['captain']->status_caption_type == 'scooter','dashboard.call-center.captains.tabs.profile.scooter_content_tab')
                                @includeWhen($data['captain']->status_caption_type == 'tricycle','dashboard.call-center.captains.tabs.profile.tricycle_content_tab')
                            </div>
                            <!-- End Tab Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Tabs -->
</div>
<!-- End Content and Tabs -->
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function handleCaptainStatusChange(selectElement) {
            if (selectElement.value === 'block') {
                $('#blockCaptainModal').modal('show');
            } else {
                selectElement.form.submit();
            }
        }
</script>
@endsection