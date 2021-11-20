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

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            New Rate
        </button>
        <!--end::Actions-->

    </div>

@endsection


@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 bg-white border-b border-gray-200">
                 <div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between">
                <h3 class=" font-weight-bolder  "><i class="fas fa-money-bill-alt mr-2"></i>@lang('Edit Currency')</h3>
                     @if($edit->rates->count()>0)

                          <h3>Now Rate <span class="text-success p-1 bg-light-success rounded">Buy {{number_format($edit->rates->last()->rate,2)}}</span>
                              <span class="text-danger p-1 bg-light-danger rounded">Sell {{number_format($edit->rates->last()->rate_sell,2)}}</span></h3>
                     @endif
                     <img src="{{$edit->image}}" width="30px">

                 </div>

                <form action="{{route('currencies.update',$edit->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" value="{{$edit->name}}">
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

                        <button type="submit" class="btn btn-primary btn btn-block">@lang('Update')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 bg-white border-b border-gray-200">
                <div class="bg-white p-4 mb-4 shadow-sm d-flex justify-content-between">
                    <h3 class=" font-weight-bolder  "></i>@lang('Currencies Transaction')</h3>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>

                            <th>@lang('Id')</th>
                            <th>@lang('Rate')</th>
                            <th>@lang('By User')</th>
                            <th>@lang('Created')</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($edit->rates as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{number_format($item->rate)}}</td>
                                <td>{{$item->users->name}}</td>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">New Rate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('rate.update',$edit->id)}}" method="post">
                    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-success">Rate Buy</label>
                <input type="number" class="form-control"  name="rate" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="text-danger">Rate Sell</label>
                        <input type="number" class="form-control" name="rate_sell" step="0.01" required>
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
