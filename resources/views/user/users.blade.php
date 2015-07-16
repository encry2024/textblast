@extends('...app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
<div class="container">
	@include('util.m-sidebar')
	<div class="col-lg-11">
		<div class="panel panel-default col-lg-12" STYLE="border-top-left-radius: 0px;">
			<div class="page-header">
				<h3><span class="glyphicon glyphicon-user"></span> Registered Users</h3>
			</div>
			{!! $accounts->render() !!}
			<table id="messages" class="table">
				<tr>
					<th></th>
					<th>Email</th>
					<th>Name</th>
					<th>Account Status</th>
				</tr>
				<?php $count = $accounts->firstItem() ?>
				@foreach($accounts as $account)
					<tr>
						<td>{{ $count++ }}</td>
						<td><a href="{{ url('user/' . $account->id) }}">{{ $account->email }}</a></td>
						<td>{{ $account->name }}</td>
						<td>{{ $account->status != 1 ? '<code>INACTIVE</code>' : 'ACTIVE' }}</td>
					</tr>
				@endforeach
			</table>
			{!! $accounts->render() !!}
			<br/><br/>
		</div>
	</div>
</div>
@stop

@section('script')
@stop