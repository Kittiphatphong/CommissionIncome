@extends('layouts.newApp')
@section('title','Trade Type')

@section('header')


    <div class="d-flex align-items-baseline flex-wrap mr-5">

        <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Trade Type')</h5>
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
                <a href="{{route('trade-type.index')}}" class="text-muted">@lang('Trade Type')</a>
            </li>

        </ul>
        <!--end::Breadcrumb-->
    </div>
    <div class="d-flex align-items-center">
        <!--begin::Actions-->

{{--        <button class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i>@lang('New Type')</button>--}}

        <!--end::Actions-->

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 bg-white border-b border-gray-200">
                <div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between">
                    <h3 class=" font-weight-bolder  "><i class="fas fa-chart-bar mr-2"></i>@lang('Edit Trade Type')</h3>

                </div>

                <form action="{{route('trade-type.update',$edit->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="input-group mb-3">

                            <input type="number" class="form-control" name="timeout" value="{{$edit->timeout}}" aria-label="Amount (to the nearest dollar)" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">@lang('second')</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Min')</label>
                            <input type="text" name="min" class="form-control" id="money" value="{{$edit->min}}">
                        </div>
                        <div class="form-group">
                            <label>@lang('Max')</label>
                            <input type="text" name="max" class="form-control" id="money" value="{{$edit->max}}">
                        </div>
                        <div class="form-group">
                            <label>@lang('Percent')</label>
                            <input type="number" name="percent" class="form-control"  value="{{$edit->percent}}">
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
