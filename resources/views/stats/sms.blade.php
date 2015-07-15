@extends('app')

@section('header')
    @include('util.m-topbar')
@stop

@section('content')

    <div class="container">
        @include('util.m-sidebar')
        <div class="col-lg-11">
            <div class="panel panel-default col-lg-12" style=" border-top-left-radius: 0px; ">

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