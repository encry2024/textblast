@extends('app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
<div class="container">
	@include('util.m-sidebar')
	<div class="col-lg-9 col-md-offset-center-2">
		<br/>
		<div class="panel panel-default col-lg-12">
			<h3><span class="glyphicon glyphicon-user"></span> History</h3>
			<hr/>
			<form class="form-horizontal">
				<div class="form-group">
					<div class="col-lg-4">
						<input type="search" class="form-control" id="filter" name="filter" placeholder="Enter your query">
					</div>
					<button type="submit" class="btn btn-default">Filter</button>
					<a role="button" class="btn btn-default" href="{{ route('activity.index') }}">Clear filter</a>
				</div>
			</form>
				<br/>
					<form class="form-horizontal">
						@foreach ($activities as $event)
						<div class="form-group">
							@include("events.{$event->name}")
						</div>
						@endforeach
					</form>
			<br/>
			<span class="right">{!! $activities->appends(Request::only('filter'))->render() !!}</span>
		</div>
	</div>
</div>
@stop

@section('script')
<script>
$('documents').ready(function () {

});
</script>
@stop