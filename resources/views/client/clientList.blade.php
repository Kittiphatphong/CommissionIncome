@extends('layouts.newApp')
@section('title','Client')
@section('header')
    <!--begin::Info-->
    <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Client</h5>
        <!--end::Page Title-->
        <!--begin::Actions-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <a href="{{route('clients.index')}}" class="text-muted font-weight-bold mr-4">List</a>
{{--        <a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a>--}}
        <!--end::Actions-->
    </div>
    <!--end::Info-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">


    </div>
    <!--end::Toolbar-->
@endsection

@section('content')

    <div class="col-lg-12  order-1 order-xxl-2">
        <!--begin::List Widget 8-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bolder text-dark">Client list</h3>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-ver"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-header pb-1">
                                    <span class="text-primary text-uppercase font-weight-bold font-size-sm">Add new:</span>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-shopping-cart-1"></i>
																		</span>
                                        <span class="navi-text">Order</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-calendar-8"></i>
																		</span>
                                        <span class="navi-text">Event</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-graph-1"></i>
																		</span>
                                        <span class="navi-text">Report</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-rocket-1"></i>
																		</span>
                                        <span class="navi-text">Post</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-writing"></i>
																		</span>
                                        <span class="navi-text">File</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>

                            <th>ID</th>
                            <th>EMAIL</th>
                            <th>FULL NAME</th>
                            <th>BIRTHDAY</th>
                            <th>@lang('STATUS')</th>
                            <th>OTP STATUS</th>
                            <th>WALLET</th>
                            <th>ACTION</th>
                            <th>UPDATED</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_clients as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if($item->firstname == null)
                                        <span class="text-danger">N/A</span>
                                    @else
                                    {{$item->firstname}} {{$item->lastname}} ({{$item->gender}})
                                    @endif
                                </td>

                                <td>
                                    @if($item->birthday == null)
                                        <span class="text-danger">N/A</span>
                                    @else
                                        {{$item->birthday}}
                                    @endif
                                </td>


                                <td>
                                    <span class="btn  font-weight-bolder btn-sm
                                    @if($item->client_statuses->id == 1)
                                    btn-secondary
                                    @elseif($item->client_statuses->id ==2)
                                    btn-light-warning
                                    @elseif($item->client_statuses->id ==3)
                                    btn-light-danger
                                    @elseif($item->client_statuses->id ==4)
                                    btn-light-success
                                    @endif
                                    ">
                                        {{$item->client_statuses->name}}
                                    </span>

                                </td>

                                <td>
                                    @if($item->otps->status == 0)
                                        <span class="btn  font-weight-bolder btn-sm btn-light-warning">
                                             Start
                                        </span>
                                    @elseif($item->otps->status == 1)
                                        <span class="btn  font-weight-bolder btn-sm btn-light-success">
                                            Success
                                        </span>

                                        @elseif($item->otps->status == 2)
                                        <span class="btn  font-weight-bolder btn-sm btn-light-primary">
                                            Set Password
                                        </span>

                                    @elseif($item->otps->status == 3)
                                        <span class="btn  font-weight-bolder btn-sm btn-light-warning">
                                            Forgot Password
                                        </span>

                                    @endif
                                </td>
                                <td>
                                @foreach($item->wallet() as $wallet)
                                [<span class="bg-light-primary">{{$wallet['crypto']}}</span>:<span class="font-weight-bold text-primary">{{$wallet['amount']}}</span>]
                                @endforeach
                                </td>

                                <td>
                                    <div class="d-flex justify-content-start m-0">
                                        <a href="{{route('clients.show',$item->id)}}" class="btn btn-link" ><i class="fas fa-book text-primary"></i></a>


                                        <form action="{{route('clients.destroy',$item->id)}}" method="post" class="{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=" btn btn-link delete_button" data-id="{{$item->id}}"><i class="fas fa-trash text-danger"></i></button>
                                        </form>

                                    </div>

                                </td>
                                <td>{{$item->updated_at}}</td>



                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!--end::Body-->
        </div>
        <!--end: Card-->
        <!--end::List Widget 8-->
    </div>


@endsection
