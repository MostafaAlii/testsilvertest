@extends('layouts.master')
@section('css')
@section('title')
{{ $data['captain']->name . ' ' . $title }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ $data['captain']->name . ' ' . $title }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('callCenter.dashboard')}}" class="default-color">Dasboard</a></li>
                <li class="breadcrumb-item active">{{ $data['captain']->name . ' ' . $title }}</li>
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
                @if(!empty($data['emptyFields']))
                    <div class="alert alert-warning">
                        <p>The following fields are empty:</p>
                        <ul>
                            @foreach($data['emptyFields'] as $emptyField)
                                <li>{{ $emptyField }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('CallCenterCaptains.updateMyCar', $data['captain']->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="projectinput1">Car-Make</label>
                            <select name="car_make_id" id="car_makeId" class="form-control p-1 car_makeId">
                                <optgroup label="Select Car-Make">
                                    @foreach($data['carMakes'] as $carMake)
                                        <option value="{{ $carMake->id }}" {{ $data['carCaption']->car_make_id == $carMake->id ? 'selected' : '' }}>
                                            {{ $carMake->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('car_make_id')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="projectinput2">Car-Model</label>
                            <select name="car_model_id" id="car_modelId" class="form-control p-1">
                                <optgroup label="Select Car-Model">
                                    @foreach($data['carModels'] as $carModel)
                                        <option value="{{ $carModel->id }}" {{ $data['carCaption']->car_model_id == $carModel->id ? 'selected' : '' }}>
                                            {{ $carModel->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('car_model_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                        
                    <!-- End CarModel Selected -->
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="projectinput1">Car-Type</label>
                            <select name="car_type_id" class="form-control p-1">
                                <optgroup label="Select Car-Type">
                                    @foreach($data['carTypes'] as $carType)
                                        <option value="{{ $carType->id }}" {{ $data['carCaption']->car_type_id == $carType->id ? 'selected' : '' }}>
                                            {{ $carType->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('car_type_id')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group col-6">
                            <label for="projectinput1">Car-Category</label>
                            <select name="category_car_id" class="form-control p-1">
                                <optgroup label="Select Car-Category">
                                    @foreach($data['carCategories'] as $carCategory)
                                        <option value="{{ $carCategory->id }}" {{ $data['carCaption']->category_car_id == $carCategory->id ? 'selected' : '' }}>
                                            {{ $carCategory->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('category_car_id')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="number_car">car number</label>
                            <input type="text" class="form-control" required name="number_car" id="number_car" value="{{ $data['carCaption']->number_car ?? '' }}">
                            @error('number_car')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="year_car">car year</label>
                            <input type="text" class="form-control" required name="year_car" id="year_car" value="{{ $data['carCaption']->year_car ?? '' }}">
                            @error('year_car')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="color_car">Car Color</label>
                            <input type="text" class="form-control" required name="color_car" id="color_car" value="{{ $data['carCaption']->color_car ?? '' }}">
                            @error('color_car')
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

@endsection