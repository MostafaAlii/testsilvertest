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
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Dasboard</a></li>
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
    <div class="col-md-12 col-lg-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <!--begin::Table-->
                {{--{!! $trashedDataTable->table([
                'class' => 'dataTable table table-row-dashed table-striped table-hover table-borderd table-row-gray-300
                align-middle gs-0 table-row-bordered gy-5',
                'style' => 'border-collapse: collapse; border-spacing: 0; width: 100%;'
                ]) !!}--}}
                <!--end::Table-->
                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Call-Center</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($data['captains'] as $captain)
                            <tr>
                                <td>{{ $captain->id }}</td>
                                <td>{{ $captain->name }}</td>
                                <td>{{ $captain->email }}</td>
                                <td>{{ $captain->phone }}</td>
                                <td>{{ $captain?->callcenter?->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#restore{{ $captain->id }}" title="restore">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- restore -->
                            <div class="modal fade" id="restore{{ $captain->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $captain->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('captains.restore', $captain->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="alert alert-primary">
                                                    <h4 class="text-center">Are You Sure ? to restore <span class="text-primary">{{$captain->name}}</span></h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        {{ trans('general.close') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-success">restore</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End restore -->
                            @endforeach
                        </tbody>
                    </table>
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
@endsection
