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

        <button class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i>@lang('New Type')</button>

        <!--end::Actions-->

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <h3 class="bg-white  font-weight-bolder  p-4 mb-4 shadow-sm"><i class="fas fa-chart-bar fa-lg mr-2"></i>@lang('Trade Type List')</h3>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>

                            <th>@lang('Id')</th>
                            <th>@lang('Time')</th>
                            <th>@lang('Time Out')</th>
                            <th>@lang('Percent')</th>
                            <th>@lang('Count')</th>
                            <th>@lang('Created at')</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_trade_types as $item)
                            <tr>
                                <td>{{$item->id}}</td>

                                <td>{{gmdate("i:s",$item->timeout)}}</td>
                                <td>
                                  {{$item->timeout}}
                                </td>
                                <td>
                                    {{$item->percent}} %
                                </td>
                                <td>
                                    10
                                </td>

                                <td>{{$item->created_at}}</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('New Type')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('trade-type.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mb-3">

                            <input type="number" class="form-control" name="timeout" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">@lang('second')</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
