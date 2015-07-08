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
			<h3>Audit Trail</h3>
			<hr/>
			<form class="form-horizontal">
				<div class="form-group">
					<div class="col-lg-4">
						<input type="search" class="form-control" id="filter" name="filter" placeholder="Enter your query">
					</div>
					<button type="submit" class="btn btn-default">Filter</button>
					<a role="button" class="btn btn-default" href="{{ route('activity.index') }}">Clear filter</a>
					@if (Request::has('filter'))
						<label class="col-lg-offset-3">Filter Result: {{ count($activities) }} out of {{ count($total_activities) }}</label>
					@endif
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
			@if (Request::has('filter'))
			<form class="form-inline">
				<div class="form-group left" style=" margin-top: 2.55rem; ">
					<label class="" for="">Showing {{ count($activities) == 0 ? count($activities) . ' to '.  $activities->lastItem() . ' out of ' . $activities->total() : $activities->firstItem() . ' to ' . $activities->lastItem() . ' out of ' . $activities->total() . ' Events'  }}</label>
				</div>
				<div class="form-group right">
					<span class="right">{!! $activities->appends(Request::only('filter'))->render() !!}</span>
				</div>
			</form>
			@else
				<form class="form-inline">
					<div class="form-group left" style=" margin-top: 2.55rem; ">
						<label class="" for="">Showing {!! $activities->firstItem() !!} to {!! $activities->lastItem() !!} out of {!! $activities->total() !!} Events</label>
					</div>
					<div class="form-group right">
						<span class="right">{!! $activities->appends(Request::only('filter'))->render() !!}</span>
					</div>
				</form>
			@endif
		</div>
	</div>
</div>
@stop