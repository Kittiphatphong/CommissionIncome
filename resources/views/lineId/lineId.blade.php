@extends('layouts.newApp')
@section('title','Line Id')

@section('header')


    <div class="d-flex align-items-baseline flex-wrap mr-5">

        <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Line Id')</h5>
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
                <a href="{{route('line-id.index')}}" class="text-muted">@lang('Line Id')</a>
            </li>

        </ul>
        <!--end::Breadcrumb-->
    </div>
    <div class="d-flex align-items-center">
        {{--        <!--begin::Actions-->--}}

        {{--        <button class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i>@lang('New Type')</button>--}}

        {{--        <!--end::Actions-->--}}

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 bg-white border-b border-gray-200">
                <div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between">
                    <h3 class=" font-weight-bolder  "><i class="fab fa-line mr-2"></i>@lang('Change Line Id') <b>[ {{$line}} ]</b></h3>

                </div>

                <form action="{{route('line-id.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Line Id')</label>
                            <input type="text" name="line_id" class="form-control" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn btn-block">@lang('Change')</button>

                    </div>
                </form>

            </div>
        </div>
    </div>





@endsection