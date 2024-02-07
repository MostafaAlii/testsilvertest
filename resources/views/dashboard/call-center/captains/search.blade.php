@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <ol class="float-left pt-0 pr-0 breadcrumb float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Dasboard</a></li>
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


                    <br>
                    <br>

                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">email</th>
                            <th scope="col">phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($dataIn->count() > 0)
                            @foreach($dataIn as $data)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>{{$data->owner->name ?? null}}</td>
                                    <td>{{$data->owner->email ?? null}}</td>
                                    <td>{{$data->owner->phone ?? null}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        {!! $dataIn->render() !!}
                    </table>

                </div>


            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
@endsection
