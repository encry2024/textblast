@extends('app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
<div class="container">
    <div class="col-lg-9 col-md-offset-center-2">
    <br/>
        <div class="panel panel-default col-lg-12">
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-inbox"></span> Sent SMS</h3>
           </div>
           <br/>
           <table id="sent" class="table"></table>
           <br/><br/>
        </div>
    </div>
</div>
@stop

@section('script')
@stop