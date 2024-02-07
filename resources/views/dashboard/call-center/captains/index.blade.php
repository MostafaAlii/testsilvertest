@extends('layouts.master')
@section('css')
@section('title')
{{$data['title']}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> {{$data['title']}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('callCenter.dashboard')}}" class="default-color">Dasboard</a></li>
                <li class="breadcrumb-item active">{{$data['title']}}</li>
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




                <div class="input-group mb-3">
                    <form action="{{route('captains.searchNumber')}}" method="get">
                        @csrf
                    <input type="text" class="form-control" name="number" placeholder="number" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="submit" >Button</button>
                    </div>
                    </form>
                </div>


                <a data-target="#create{{$data['title']}}" data-toggle="modal"  data-effect="effect-scale" class="btn btn-success btn-sm" role="button">
                    <i class="fa fa-plus"></i>
                    Add New {{$data['title']}}
                </a>
                <a data-target="#create_new_car" data-toggle="modal"  data-effect="effect-scale" class="btn btn-dark text-white btn-sm" role="button">
                    <i class="fa fa-plus"></i>
                    Add New Car
                </a>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Push Notification All  {{$data['title']}}</button>
                <br><br>
                <div class="mb-3 mt-2 text-center">
                    <p class="text-bold">
                        <span class="mr-3 text-bold text-white p-1" style="background-color: #808080; border-radius: 5px;">Gray For Not Active Media</span>
                        <span class="mr-3 text-bold text-white p-1" style="background-color:  #8A2BE2; border-radius: 5px;">Purple For Rejected Media</span>
                        <span class="mr-3 text-bold text-white p-1" style="background-color:  #ffc107; border-radius: 5px;">Warning No Have any Media</span>
                        <span class="mr-3 text-bold text-white p-1" style="background-color:  #28a745; border-radius: 5px;">Success All Is Accepted</span>
                    </p>
                </div>

                <br>
                <!--begin::Table-->
                <div class="table-responsive">
                    {!! $dataTable->table([
                    'class' => 'dataTable table table-row-dashed table-striped table-hover table-borderd table-row-gray-300
                    align-middle gs-0 table-row-bordered gy-5',
                    'style' => 'border-collapse: collapse; border-spacing: 0; width: 100%;'
                    ]) !!}
                    <!--end::Table-->
                </div>
            </div>
            @include('dashboard.call-center.captains.btn.modals.create')
            @include('dashboard.call-center.captains.btn.modals.createNewCar')
            @include('dashboard.call-center.captains.notification')
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{!! $dataTable->scripts() !!}
<script>
    $(document).ready(function () {
        $('#car_make_id').change(function () {
            var carMakeId = $(this).val();
            console.log(carMakeId);
            $.ajax({
                url: '/callCenter/get-car-models/' + carMakeId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#car_model_id').empty();
                    $.each(data, function (name, id) {
                        $('#car_model_id').append('<option value="' + id + '">' + name + '</option>');
                    });
                    if (Object.keys(data).length > 0) {
                        $('#car_model_id').parent().show();
                    } else {
                        $('#car_model_id').parent().hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        
    });
</script>



<script>
    const colorPreview = document.getElementById('colorPreview');
    colorInput.addEventListener('change', function() {
        const selectedColor = colorInput.value;
        colorPreview.style.backgroundColor = selectedColor;
        colorPreview.style.display = 'block';
    });
</script>


@endsection
