@extends('layouts.newApp')
@section('title','Trade')

@section('header')


    <div class="d-flex align-items-baseline flex-wrap mr-5">

        <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Trade')</h5>
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
                <a href="{{route('trade-type.index')}}" class="text-muted">@lang('Trade')</a>
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

                <h3 class="bg-white  font-weight-bolder  p-4 mb-4 shadow-sm"><i class="fas fa-chart-bar fa-lg mr-2"></i>@lang('Trade List')</h3>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>

                            <th>@lang('Id')</th>
                            <th>@lang('Client')</th>
                            <th>@lang('Trade Type')</th>
                            <th>@lang('Trade Amount')</th>
                            <th>@lang('Crypto Trade')</th>
                            <th>@lang('Update By')</th>
                            <th>@lang('Trade Result')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Action')</th>

                        </tr>
                        </thead>
                        <tbody  >
                        @foreach($list_trades as $item)
                            <tr class="trades">
                                <td data-trade = "{{$item->id}}">{{$item->id}}</td>
                                <td>{{$item->clients->email}}</td>
                                <td>{{$item->trade_types->timeout}} S</td>
                                <td>{{$item->trade_amount}} USDT</td>
                                <td>{{$item->trade_crypto_currency}}</td>
                                <td>
                                    @if($item->user_id != null)
                                    {{$item->users->name}}
                                    @else
                                    <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="
                                   @if($item->trade_result>0)
                                    text-success
                                    @else
                                        text-danger
                                    @endif
                                    ">
                                        {{$item->trade_result}} USDT
                                    </span>
                                </td>
                                <td>
                                    <span class="
                                   @if(\Illuminate\Support\Str::lower($item->type)=="buy")
                                        badge badge-success
@else
                                        badge badge-danger
@endif
                                        ">
                                        {{$item->type}}
                                    </span>
                                </td>
<td>
    <a href="{{route('trade.edit',$item->id)}}"  ><i class="fas fa-book text-primary"></i></a>

</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@section('script')
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        const trades = document.querySelector('.trades');

        function addTrade(trade){
            trades.insertAdjacentHTML('beforeend',note);
        }

        function updateTrade(id,created_at){
            let trade = document.querySelector( `[data-trade="${id}"]`);
            trade.innerHTML = created_at;

        }
        function deleteTrade(id){
            let trade = document.querySelector( `[data-trade="${id}"]`);
            trade.remove();
        }
        laratime.db('trades')
        .on('added',({model})=>{
            let  {id,created_at} = model;
            let trade = `<td data-trade="${id}">${created_at}</td>`;
            addNote(trade)
        })
            .on('updated',({model})=>{
                let  {id,created_at} = model;
                updateTrade(id,created_at);
            })
            .on('deleted',({model})=>{
              let {id} = model;
              deleteTrade(id);
            })
    </script>
@endsection

@endsection
