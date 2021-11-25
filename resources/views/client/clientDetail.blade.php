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

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex mb-9">
                        <!--begin: Pic-->
                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                            <div class="symbol symbol-50 symbol-lg-120">
                                @if($client->image == null)
                                    <img src="assets/media/users/default.jpg" alt="image" />
                                @else
                                    <img src="{{$client->image}}" alt="image" />
                                    @endif


                            </div>

                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between flex-wrap mt-1">
                                <div class="d-flex mr-3">
                                    <h2 class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3"><b>@if($client->firstname!=null){{$client->firstname}} {{$client->lastname}}@else <span class="text-danger">(N/A)</span> @endif</b>
                                        <span class="badge
                                    @if($client->client_statuses->id == 1)
                                            badge-secondary
@elseif($client->client_statuses->id ==2)
                                            badge-warning
@elseif($client->client_statuses->id ==3)
                                            btn-danger
@elseif($client->client_statuses->id ==4)
                                            btn-success
@endif
                                            ">
                                        {{$client->client_statuses->name}}
                                    </span>
                                    </h2>



                                </div>
                                <div class="my-lg-0 my-3 ">
                                    @if($client->kyc_clients->whereNull('status')->count()>0)
                                    <button type="button" class="btn  btn-light-success font-weight-bolder text-uppercase" data-toggle="modal" data-target="#exampleModalCenter1">
                                        @lang('Approve')
                                    </button>
                                        <button type="button" class="btn  btn-light-danger font-weight-bolder text-uppercase" data-toggle="modal" data-target="#exampleModalCenter">
                                            @lang('Reject')
                                        </button>
                                     @endif

                                        @if($client->kyc_clients->where('status',1)->count()==0 && $client->kyc_clients->count()> 0)
                                            @if($kyc_last->status === 0)

                                                <button type="button" class="btn  btn-light-danger font-weight-bolder text-uppercase" >
                                                    Rejected By <span>{{$kyc_last->users->name}}</span>
                                                </button>

                                        @endif
                                        @endif
                                                @if($client->kyc_clients->where('status',1)->count()>0 && $client->kyc_clients->count()> 0)
                                                    @if($kyc_last->status === 1)
                                                <button type="button" class="btn  btn-light-success font-weight-bolder text-uppercase" >
                                                    Approved By <span>{{$kyc_last->users->name}}</span>
                                                </button>
                                                    @endif
                                   @endif

                                </div>

                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-1">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap mb-4">
                                        <span class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{$client->email}}</span>
                                        <span href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-calendar-2 mr-2 font-size-lg"></i>@if($client->birthday != null){{\Carbon\Carbon::parse($client->birthday)->format('d/m/Y')}}@else <span class="text-danger">(N/A)</span>@endif</span>
                                        <span href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                            <i class="fas fa-venus-mars mr-2 font-size-lg"></i>@if($client->gender !=null){{$client->gender}}@else <span class="text-danger">(N/A)</span>@endif</span>
                                    </div>
                                    <span class="font-weight-bold "><b>OTP INFO</b></span>
                                    <div class="d-flex flex-wrap mb-4">
                                        <span class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="fas fa-paper-plane mr-2 font-size-lg"></i>Requested( {{$client->otps->limit_request}} )</span>
                                        <span href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                           <i class="fas fa-keyboard mr-2 font-size-lg"></i>Input( {{$client->otps->limit_input}} )</span>
                                        @if($client->otps->status == 0)
                                            <span class="font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2text-dark-50">
                                                <i class="flaticon2-list-2 mr-2 font-size-lg"></i>
                                             Start
                                        </span>
                                        @elseif($client->otps->status == 1)
                                            <span class="text-success font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                 <i class="flaticon2-list-2 mr-2 font-size-lg"></i>
                                            Success
                                        </span>

                                        @elseif($client->otps->status == 2)
                                            <span class="font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2text-primary">
                                                 <i class="flaticon2-list-2 mr-2 font-size-lg"></i>
                                            Set Password
                                        </span>

                                        @elseif($client->otps->status == 3)
                                            <span class="font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2 text-warning">
                                                <i class="flaticon2-list-2 mr-2 font-size-lg"></i>
                                            Forgot Password
                                        </span>

                                        @endif
                                    </div>
{{--                                    <span class="font-weight-bold text-dark-50">A second could be persuade people.You want people to bay objective</span>--}}
                                </div>
                                <div class="d-flex align-items-center w-25 flex-fill float-right mt-lg-12 mt-8">
                                    <span class="font-weight-bold text-dark-75">Progress</span>
                                    <div class="progress progress-xs mx-3 w-100">
                                        <div class="progress-bar
                                        @if($client->clientProgress() >= 50)
                                        bg-success
                                        @else
                                        bg-danger
                                        @endif
                                      " role="progressbar" style="width: {{$client->clientProgress()}}%;"  aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="font-weight-bolder text-dark">{{$client->clientProgress()}}%</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <div class="separator separator-solid"></div>
                    <!--begin::Items-->
                    <div class="d-flex align-items-start flex-wrap mt-8">
                    @foreach($client->wallet() as $wallet)
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-piggy-bank display-4 text-muted font-weight-bold"></i>
												</span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{$wallet['crypto']}}</span>
                                <span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 font-weight-bold"></span>{{$wallet['amount']}}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                    @endforeach



                    </div>
                    <!--begin::Items-->
                </div>
            </div>
            <!--end::Card-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-8">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Client KYC {{$client->kyc_clients->count()}}</span>
                                @if($client->kyc_clients->count()>0)

                                    @if($kyc->status === null)
                                        <span class="bg-light-primary p-2 rounded text-primary mt-3 font-weight-bold font-size-sm">Pending</span>
                                    @elseif($kyc->status === 0)
                                        <span class="bg-light-primary p-2 rounded text-danger mt-3 font-weight-bold font-size-sm">Rejected by {{$kyc->users->name}}</span>
                                    @elseif($kyc->status === 1)
                                        <span class="bg-light-primary p-2 rounded text-success mt-3 font-weight-bold font-size-sm">Approved by {{$kyc->users->name}}</span>
                                    @endif
                                @endif

                            </h3>
                            <div class="card-toolbar">
                                @if($client->kyc_clients->count()>0)
                                    <div class="border">
                                {{$kyc->comment}}
                                    </div>
                                @if($kyc->status === null)
                                    <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="" />
														</span>
                                    </div>
                                @elseif($kyc->status === 0)
                                    <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/012-foursquare.svg" class="h-50 align-self-center" alt="" />
														</span>
                                    </div>
                                @elseif($kyc->status === 1)
                                    <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="" />
														</span>
                                    </div>
                                @endif
                                    @endif
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        @if($client->kyc_clients->count()>0)
                        <div class="card-body pt-2 pb-0 mt-n3">
                            <div class="tab-content mt-5" id="myTabTables11">
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade show active" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                                    <div  class="row ">
                                   <div class="border col-4 py-2">
                                       <h4 class="text-center font-weight-bold my-2">Text Info</h4>
                                       <div class="table-responsive">
                                       <table class="table table-bordered table-primary">
                                           <thead>
                                           <tr>
                                               <td >{{$kyc->kyc_types->name}} No</td>
                                               <td>{{$kyc->number}}</td>

                                           </tr>
                                           <tr>
                                               <td >Full Name</td>
                                               <td>@if($client->firstname!=null){{$client->firstname}} {{$client->lastname}}@else <span class="text-danger">(N/A)</span> @endif</td>

                                           </tr>
                                           <tr>
                                               <td >
                                                   <div class="d-flex justify-content-start">
                                                   Country
                                                   <div class="item ml-1" style="width: 32px;"><a href="flag/{{$kyc->countries->code2l.".svg"}}" data-lightbox="image"><img class="img-fluid" src="flag/{{$kyc->countries->code2l.".svg"}}"></a></div>
                                                   </div>
                                               </td>

                                               <td>{{$kyc->countries->name}}</td>

                                           </tr>
                                           </thead>

                                       </table>
                                       </div>
                                   </div>
                                    <div class="border col-4 py-2">
                                        <h4 class="text-center font-weight-bold my-2">{{$kyc->kyc_types->name}} Image</h4>
                                        <div class="d-flex justify-content-center">
                                            <div class="item" style="width: 300px;"><a href="{{$kyc->image}}" data-lightbox="image"><img class="img-fluid" src="{{$kyc->image}}"></a></div>
                                        </div>
                                    </div>
                                    <div class="border col-4 py-2 tex">
                                        <h4 class="text-center font-weight-bold my-2">Selfie Image</h4>
                                        <div class="d-flex justify-content-center">
                                        <div class="item " style="width: 300px;"><a href="{{$kyc->selfie_image}}" data-lightbox="image"><img class="img-fluid" src="{{$kyc->selfie_image}}"></a></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!--end::Tap pane-->

                            </div>
                        </div>
                        @endif
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>
                <div class="col-lg-4">
                    <!--begin::Mixed Widget 14-->
                    <div class="card card-custom card-stretch gutter-b overflow-auto" style="height: 500px">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title font-weight-bolder">KYC LIST</h3>
                            <div class="card-toolbar">
                                <div class="dropdown dropdown-inline">

                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column">

                                    <!--begin::Item-->
                                    @foreach($client->kyc_clients->sortByDesc('no') as $i)
                                    <form href="{{route('clients.show',$client->id)}}" method="get">
                                        <!--begin::Symbol-->
                                        <input type="hidden" name="kyc_id" value="{{$i->id}}">
                                        <button type="submit" class="d-flex align-items-center flex-wrap mb-5 btn @if($kyc->no == $i->no) btn-primary @else btn-light-primary @endif  col-12 border">
                                        @if($i->status === null)
                                        <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="" />
														</span>
                                        </div>
                                        @elseif($i->status === 0)
                                            <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/012-foursquare.svg" class="h-50 align-self-center" alt="" />
														</span>
                                            </div>
                                        @elseif($i->status === 1)
                                            <div class="symbol symbol-50 symbol-light mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="" />
														</span>
                                            </div>
                                        @endif
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <span class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{$i->kyc_types->name}}</span>
                                            <span class="text-muted font-weight-bold">{{$i->created_at}}</span>
                                        </div>
                                        <!--end::Text-->
                                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder">{{$i->no}}</span>
                                    </button>
                                    </form>


                                    @endforeach

                                <!--end::Body-->

                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 14-->
                </div>
            </div>
            <!--end::Row-->

        </div>
        <!--end::Container-->
    </div>



    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Review KYC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('clients.update',$client->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                <div class="modal-body">
                 <div class="form-group">
                     <label>Comment</label>
                     <textarea name="comment" class="form-control" rows="5" required></textarea>
                 </div>
                    <input type="hidden" name="action" value="reject">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn  btn-light-danger font-weight-bolder text-uppercase ">@lang('Reject')</button>

                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Review KYC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('clients.update',$client->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment" class="form-control" rows="5" required></textarea>
                        </div>
                        <input type="hidden" name="action" value="approve">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn  btn-light-success font-weight-bolder text-uppercase ">@lang('Approve')</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
