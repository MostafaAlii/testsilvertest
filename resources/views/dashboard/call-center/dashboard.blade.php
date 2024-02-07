@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/css/plugins/toastr.css') }}" rel="stylesheet">
@section('title')
{{get_user_data()->name . ' ' . $title }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">
                {{ get_user_data()->name . ' ' . $title }}
            </h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                @section('breadcrumb')
                @show
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
                <!-- Start First Row -->
                <div class="row">
                    <!-- Start Drivers Row -->
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <span class="text-warning">
                                            <i class="fa fa-user-circle highlight-icon" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="float-right text-right">
                                        <a href="{{route('CallCenterCaptains.index')}}">
                                            <p class="card-text text-dark">Captain</p>
                                            <h4>
                                                {{Captain::whereCountryId(get_user_data()->country_id)->where('callcenter_id', '=', get_user_data()->id)?->count()}}
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                                <p class="pt-3 mt-2 mb-0 text-muted border-top">
                                <p>
                                    @if(Captain::whereCountryId(get_user_data()->country_id)->where('callcenter_id', '=', get_user_data()->id)->whereGender('male')->count()
                                    > 0)
                                    <span
                                        class="badge badge-success">{{Captain::whereCountryId(get_user_data()->country_id)->where('callcenter_id', '=', get_user_data()->id)->whereGender('male')?->count()}}</span>
                                    Male Captain -
                                    <span
                                        class="badge badge-primary">{{Captain::whereCountryId(get_user_data()->country_id)->where('callcenter_id', '=', get_user_data()->id)->whereGender('female')?->count()}}</span>
                                    Female Captain
                                    @else
                                    <span class="text-danger">
                                        No Captain in {{ get_user_data()->country->name }}
                                    </span>
                                    @endif
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Drivers Row -->
                </div>
                <!-- End First Row -->
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
@endsection
