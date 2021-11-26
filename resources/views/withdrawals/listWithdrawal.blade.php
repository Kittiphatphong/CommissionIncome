@extends('layouts.newApp')
@section('title','Withdrawal')

@section('header')
    <div class="d-flex align-items-baseline flex-wrap mr-5">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Withdrawals')</h5>
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                <li class="breadcrumb-item">
                    <a href="{{route('withdrawals.index')}}" class="text-muted">@lang('List')</a>
                </li>
                {{--            <li class="breadcrumb-item">--}}
                {{--                <a href="" class="text-muted">Bill 3/40</a>--}}
                {{--            </li>--}}
            </ul>
            <!--end::Breadcrumb-->
        </div>
    </div>
    <div class="d-flex align-items-center">
        <!--begin::Actions-->

    {{--        <a  class="btn btn-light-primary font-weight-bolder btn-sm"  data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-house-user"></i> New User</a>--}}

    <!--end::Actions-->

    </div>
@endsection


@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">@lang('Withdraws List')</h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">

                </div>
            </div>
        </div>



        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                    <thead>
                    <tr>

                        <th>ID</th>
                        <th>CLIENT</th>
                        <th>AMOUNT</th>
                        <th>CRYPTO</th>
                        <th>STATUS</th>
                        <th>UPDATED BY</th>
                        <th>CREATED AT</th>



                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list_withdrawals as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->clients->firstname}} {{$item->clients->lastname}}<br><span class="text-primary">{{$item->clients->email}}</span></td>
                            <td>{{number_format($item->amount)}} {{$item->currencies->name}}</td>
                            <td>{{$item->crypto_amount}} {{$item->crypto_currency}}</td>
                            <td>
                                @if($item->status === null)
                                    <span class="btn  font-weight-bolder btn-sm btn-secondary">
                                            Pending
                                        </span>
                                @elseif($item->status === 0)
                                    <span class="btn  font-weight-bolder btn-sm btn-light-danger">
                                            Fail
                                        </span>
                                @elseif($item->status === 1)
                                    <span class="btn  font-weight-bolder btn-sm btn-light-success">
                                            Success
                                        </span>
                                @endif
                            </td>
                            <td>
                                @if($item->user_id != null)
                                    {{$item->users->name}}
                                @else
                                    <div class="d-flex justify-content-around m-0">
                                        <form action="{{route('withdrawals.update',$item->id)}}" method="post" class="{{"approve".$item->id}}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <button type="submit" class=" btn btn-light-success confirm_button_approve" data-id="{{$item->id}}">Approve</button>
                                        </form>


                                        <form action="{{route('withdrawals.update',$item->id)}}" method="post" class="{{"reject".$item->id}}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="0">
                                            <button type="submit" class=" btn btn-light-danger confirm_button_reject" data-id="{{$item->id}}">Reject</button>
                                        </form>
                                    </div>
                                @endif

                            </td>


                            <td>{{$item->updated_at}}</td>



                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>



    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('users.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full form-control" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full form-control"
                                     type="password"
                                     name="password"
                                     required autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full form-control"
                                     type="password"
                                     name="password_confirmation" required />
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
