@extends('layouts.newApp')
@section('title','Currencies')

@section('header')


    <div class="d-flex align-items-baseline flex-wrap mr-5">

        <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Currency')</h5>
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
                <a href="{{route('currencies.index')}}" class="text-muted">@lang('Currency')</a>
            </li>

        </ul>
        <!--end::Breadcrumb-->
    </div>
    <div class="d-flex align-items-center">
        <!--begin::Actions-->

{{--        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">--}}
{{--            New Rate--}}
{{--        </button>--}}
        <!--end::Actions-->

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 bg-white border-b border-gray-200">
                <div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between">
                    <h3 class=" font-weight-bolder  "><i class="fas fa-chart-bar mr-2"></i>@lang('Edit Trade')</h3>

                </div>

                <form action="{{route('trade.update',$edit->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Trade Result')</label>
                            <input type="number" name="trade_result" class="form-control" value="{{$edit->trade_result}}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn btn-block">@lang('Update')</button>

                    </div>
                </form>

            </div>
        </div>
    </div>





@endsection
