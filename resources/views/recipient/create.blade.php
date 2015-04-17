@extends('app')

@section('header')
    @include('util.m-topbar')
@stop

@section('content')
<div class="container">
    <div class="col-lg-3">
        <br/>
        <div class="panel panel-default col-lg-12">
            <div class="panel-body left">
                <a href="#" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-plus"></span> Add Contact</a>
                <br/><br/>
                <a href="#" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-th-list"></span> Add to Group</a>
                <div></div>
                <br/><br/>
                <div class="sprtr"></div>
                <br/>
                <a href="{{route('/home') }}" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-menu-left" ></span> Back to Home</a>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-offset-center-2">
    <br/>
        <div class="panel panel-default col-lg-12">
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-book"></span> Contacts</h3>
           </div>
           <table id="phonebook" class="table"></table>
        </div>
    </div>
</div>
@stop

@section('script')
@stop