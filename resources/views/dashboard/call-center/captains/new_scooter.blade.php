@extends('layouts.master')
@section('css')
@section('title')
{{ $captain->name . ' ' . $data['title'] }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ $captain->name . ' ' . $data['title'] }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('callCenter.dashboard')}}" class="default-color">Dasboard</a></li>
                <li class="breadcrumb-item active">{{ $captain->name . ' ' . $data['title'] }}</li>
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
                <form id="newScooter" action="{{route('createNewScooter')}}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Start Captain Selected -->
                        <input type="hidden" name="captain_id" value="{{$captain->id }}" />
                        <!-- End Captain Selected -->
                        <div class="form-group col-4">
                            <label for="projectinput1">Scooter-Make</label>
                            <select name="scooter_make_id" id="scooter_makeId" class="form-control p-1 scooter_makeId" required>
                                <optgroup label="Select Scooter-Make">
                                    <option value="" disabled selected>Select Scooter Make</option>
                                    @foreach ($data['scooterMakes'] as $scooterMake)
                                        <option value="{{ $scooterMake['id'] }}">{{ $scooterMake['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('scooter_make_id')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                        </div>
                        <!-- End CarMake Selected -->
                        <div class="form-group col-4">
                            <label for="projectinput2">Scooter-Model</label>
                            <select name="scooter_model_id" id="scooter_modelId" class="form-control p-1" required></select>
                            @error('scooter_model_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    <!-- End CarModel Selected -->
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="number_car">Scooter Number</label>
                            <input type="text" class="form-control" required name="scooter_number" id="scooter_number" value="">
                            @error('scooter_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="scooter_color">Scooter Color</label>
                            <input type="text" class="form-control" required name="scooter_color" id="scooter_color" value="">
                            @error('scooter_color')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="scooter_year">Scooter year</label>
                            <input type="text" class="form-control" required name="scooter_year" id="scooter_year" value="">
                            @error('scooter_year')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">{{ trans('general.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    $(document).ready(function () {
        var form = $('#newScooter');
        form.on('change', '.scooter_makeId', function () {
            var scooter_makeId = $(this).val();
            $.ajax({
                url: '/callCenter/get-scooter-models/' + scooter_makeId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#scooter_modelId').empty();
                    $.each(data, function (name, id) {
                        $('#scooter_modelId').append('<option value="' + id + '">' + name + '</option>');
                    });
                    if (Object.keys(data).length > 0) {
                        $('#scooter_modelId').parent().show();
                    } else {
                        $('#scooter_modelId').parent().hide();
                    }
                },
                error: function (xhr, status, error) {
                }
            });
        });
        form.on('change', '#scooter_modelId', function () {
            var scooter_modelId = $(this).val();
        });
    });
</script>

@endsection