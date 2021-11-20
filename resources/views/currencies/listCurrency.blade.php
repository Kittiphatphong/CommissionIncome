@extends('layouts.newApp')
@section('title','Currency')

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

        <button class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i>@lang('New Currency')</button>

        <!--end::Actions-->

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <h3 class="bg-white  font-weight-bolder  p-4 mb-4 shadow-sm"><i class="fas fa-money-bill-alt fa-lg mr-2"></i>@lang('Currency List')</h3>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>

                            <th>@lang('Id')</th>
                            <th>@lang('Logo')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Rate Buy')</th>
                            <th>@lang('Rate Sell')</th>
                            <th>@lang('Update By')</th>
                            <th>@lang('Action')</th>
                            <th>@lang('Created at')</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_currencies as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>

                                    <div class="item" style="width: 50px;"><a href="{{$item->image}}" data-lightbox="image"><img class="img-fluid" src="{{$item->image}}"></a></div>

                                </td>
                                <td>{{$item->name}}</td>
                                <td>
                                    @if($item->rates->count()>0)
                                    <span class="text-success">{{number_format($item->rates->last()->rate,2)}}</span>
                                        @endif
                                </td>
                                <td>
                                    @if($item->rates->count()>0)
                                        <span class="text-danger">{{number_format($item->rates->last()->rate_sell,2)}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->rates->count()>0)
                                        {{$item->rates->last()->users->name}}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start m-0">

                                        <a href="{{route('currencies.edit',$item->id)}}" class="btn btn-link" ><i class="far fa-edit text-warning"></i></a>

                                        <form action="{{route('currencies.destroy',$item->id)}}" method="post" class="delete{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=" btn btn-link  delete_button" data-id="{{$item->id}}"><i class="fas fa-trash text-danger"></i></button>
                                        </form>

                                    </div>

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
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('New Currency')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('currencies.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('Logo')</label>
                            <input type='file' name="image" onchange="readURLImage(this);" class="form-control"/>
                            <div class="d-flex justify-content-center mt-2">
                                <img id="image" width="180px" />
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

@section('script')
    <script>

        function readURLImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

 @endsection

@endsection
