@extends('app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
<div class="container">
	@if (Session::has('success_msg'))
		<div class="alert alert-success center" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('success_msg')  }}
		</div>
	@endif

	<div class="col-lg-3">
		<div class="panel panel-default col-lg-12">
			<div class="panel-body">
				<a href="#" class="col-lg-12" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-ok"></span> Save Changes</a>
				<br/><br/>
				<a href="#" class="col-lg-12"><span class="glyphicon glyphicon-plus"></span> Add Contact</a>
				<br/><br/>
			    <a href="#" class="col-lg-12" data-toggle="modal" data-target="#tagModal"><span class="glyphicon glyphicon-tag"></span> Tag to a Group</a>
			    <br/><br/>
				<a href="#" class="col-lg-12"><span class="glyphicon glyphicon-remove"></span> Delete Recipient</a>
				<br/><br/><br/><br/><br/><br>
				<a href="{{route('pb') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Contacts</a>
			</div>
		</div>
	</div>
	<div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
			<div class="page-header">
				<h3>{{ $recipient->name }}</h3>
			</div>
			<br><br>
			<form class="form-inline" method="POST" action="{{ route('recipient/update') }}" id="updateForm">
			    <div class="form-group">
					<label class="col-md-3 control-label" style="line-height: 3rem;">Groups</label>
					@foreach ($recipientTeams as $recipientTeam)
					<div class="col-md-4 col-md-push-2">
						<input type="string" class="form-control" name="phone_number[]" value="{{ $recipientTeam->team->name }}">
					</div>
					@endforeach
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label col-md-offset-1" style="line-height: 3rem;"> Contact No#</label>
					@foreach ($rpt_nums as $rpt_num)
					<div class="col-md-4">
						<input type="string" class="form-control" name="phone_number" value="{{ $rpt_num->phone_number }}">
					</div>
					<div class="col-md-4">
						<input type="string" class="form-control" name="provider" value="{{ $rpt_num->provider }}"> 
					</div>
					@endforeach
				</div>
				<br/><br/><br><br>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	{!! Form::open(['route' => 'recipient/store']) !!}
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Recipient</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12 center col-lg-offset-1">
							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-6">
									<input type="string" class="form-control" name="name" value="{{ old('name') }}">
								</div>
							</div>
							<br/><br/>
							<div class="form-group">
								<label class="col-md-4 control-label">Phone Number</label>
								<div class="col-md-6">
									<input type="string" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
								</div>
							</div>
							<br/><br/>
							<div class="form-group" style=" margin-top: -1.5rem;">
								<label class="col-md-4 control-label">Provider</label>
								<div class="col-md-6">
									<input type="string" class="form-control" name="provider" value="{{ old('provider') }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</div>


<!-- Group Modal -->
<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {!! Form::open(['route' => 'recipientTeam.store']) !!}
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-tag"></span> Tag to Group</h4>
			</div>
			<div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 center col-lg-offset-1">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Group</label>
                                <div class="col-md-6">
                                    <div id="groupList" name="team_id"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<br/>
			<div class="modal-footer">
				{!! Form::hidden('recipient_id', $recipient->id) !!}
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@stop

@section('script')
<script>
	$.getJSON("{{ route('team') }}", function(data) {
		var datalist = [];
		console.log(data);

		$.each(data, function(key, val) {
			datalist.push({value: val.id, text: val.name});
		});

		$('#groupList').multilist({
			single: true,
			labelText: 'Select Group',
			datalist: datalist,
			enableSearch: true,
		});
	});
</script>
@stop