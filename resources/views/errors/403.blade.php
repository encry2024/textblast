@extends('...app')

@section('header')
    @include('...util.m-topbar')
@stop

@section('content')
    <div class="container">
        @include('...util.m-sidebar')
        <div class="col-lg-9 col-md-offset-center-2">
            <br/>
            <div class="panel panel-default col-lg-12">
                <h3>You are not authorize to view this page.</h3>
                <br/>
            </div>
        </div>
    </div>
@endsection