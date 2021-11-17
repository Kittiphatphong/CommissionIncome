@extends('layouts.newApp')
@section('title','Users')

@section('header')
    <div class="d-flex align-items-baseline flex-wrap mr-5">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <h5 class="text-dark font-weight-bold my-1 mr-5">@lang('Users')</h5>
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                <li class="breadcrumb-item">
                    <a href="{{route('users.index')}}" class="text-muted">@lang('List')</a>
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
{{--        <a href="{{route('role.index')}}"  class="btn btn-light-primary font-weight-bolder btn-sm"  ><i class="fas fa-house-user"></i> List Role</a>--}}
        <!--end::Actions-->
    </div>
@endsection


@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">

                </div>
            </div>
        </div>



        <div class="card-body">
<form method="post" action="{{route('users.update',$edit->id)}}">
    @csrf
    @method('PATCH')
           <div class="form-group">
               <label>Name</label>
               <input type="text" name="name" value="{{old('name',$edit->name)}}" class="form-control">
           </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" value="{{old('email',$edit->email)}}" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
{{--            <div class="form-group">--}}
{{--                <label>Role</label>--}}
{{--                <select class="form-control" name="permission">@foreach($roles as $role)--}}
{{--                        <option value="{{$role->name}}"--}}
{{--                                @if($edit->roles->count()>=1) @if($role->name==$edit->roles->first()->name) Selected @endif @endif--}}
{{--                        > {{$role->name}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
            <div class="form-group mt-4">
                <button class="btn btn-primary btn-block">Save Changes</button>
            </div>
</form>
        </div>



    </div>






@endsection
