@extends('...app')

@section('header')
	@include('...util.m-topbar')
@stop

@section('content')
<div class="container">
	@if (Session::has('success_msg'))
		<div class="alert alert-success center" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('success_msg')  }}
		</div>
	@endif
    @include('...util.m-sidebar')
    <div class="col-lg-9 col-md-offset-center-2">
    <br/>
        <div class="panel panel-default col-lg-12">
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-exclamation-sign"></span> Failed SMS</h3>
           </div>
			{!! $messages->render() !!}
			<table id="messages" class="table">
				<tr>
					<th></th>
					<th>SMS ID</th>
					<th>Message</th>
					<th>Sender</th>
					<th>Date</th>
				</tr>
				<?php $count = $messages->firstItem() ?>
				@foreach($messages as $sms)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $sms->sms->id }}</td>
						<td>
							<a href="{{ url('sms/'.$sms->sms->id.'/edit') }}">{{ strlen($sms->sms->message)>30?substr($sms->sms->message, 0, 27) . '...':$sms->sms->message }}</a>
						</td>
						<td>{{ $sms->user->name }}</td>
						<td>{{ $sms->created_at }}</td>
					</tr>
				@endforeach
			</table>
			{!! $messages->render() !!}
			<br/><br/>
		</div>
	</div>
</div>
@endsection

@section('script')
	<script type="text/javascript">

	</script>
@stop