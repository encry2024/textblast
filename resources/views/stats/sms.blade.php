@extends('app')

@section('header')
    @include('util.m-topbar')
@stop

@section('content')
    <div class="container">
        <div class="col-lg-3">
            <div class="panel panel-default col-lg-12">
                <div class="panel-body">
                    <a href="{{ url('/') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Inbox</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-offset-center-2">
            <div class="panel panel-default col-lg-12">
                <div class="page-header">
                    <h3><span class="glyphicon glyphicon-stats"></span> SMS Statistics</h3>
                    <h5></h5>
                </div>
                <form class="form-inline" role="form" method="POST">
                <h4>Date Filter: <input type="text" id="datepick" name="date" class="form-control" value="{{ old('date') }}"> <button type="submit" class="btn btn-default">Submit</button></h4>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <div id="chart-div"></div>
                {!! $lava->render('PieChart', 'SMS', 'chart-div') !!}
            </div>
        </div>

    </div>
@stop

@section('script')
    <script>
        $('#datepick').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>
@stop