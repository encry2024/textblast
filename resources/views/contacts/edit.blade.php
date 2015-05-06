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

		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="col-lg-3">
			<div class="panel panel-default col-lg-12">
				<div class="panel-body">
					<a href="#" class="col-lg-12" data-toggle="modal" data-target="#addContact"><span class="glyphicon glyphicon-plus"></span> Add Contact</a>
					<br/><br/>
					<a href="#" class="col-lg-12" data-toggle="modal" data-target="#tagModal"><span class="glyphicon glyphicon-tag"></span> Tag to a Group</a>
					<br/><br/>
					<a href="#" class="col-lg-12" data-toggle="modal" data-target="#deleteRecipient"><span class="glyphicon glyphicon-remove"></span> Delete Recipient</a>
					<br/><br/><br/><br/><br/><br>
					<a href="{{route('pb') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Contacts</a>
				</div>
			</div>
		</div>

		<div class="col-lg-9">
			<div class="panel panel-default col-lg-12">
				<h3>{{ $recipient->name }} <a href="#" title="Edit Recipient's Name" data-toggle="modal" data-target="#editName"><span class="glyphicon glyphicon-pencil size-12" style="top: -1.5rem;"></span></a></h3>
			</div>
			<br><br><br><br><br>
			<div class="panel panel-default col-lg-12">
				<h4><span class="glyphicon glyphicon-tag"></span> Tagged Groups</h4>
				<br/>
				<form class="form-inline">
				@foreach ($recipientTeams as $recipientTeam)
					<div class="form-group" style="margin-left: -1.5rem;">
						<div class="col-lg-12">
							<div class="alert alert-success col-lg-12" style="width: 105%; height: 5rem;" role="alert">
								<button type="button" class="close" onclick="untagRecipient({{$recipientTeam->id }}, '{{ $recipientTeam->team->name }}')" data-toggle="modal" data-target="#dlt"> <span class="glyphicon glyphicon-trash size-12" aria-hidden="true" style="margin-left: 0.5rem;"> </span></button>
								<button type="button" class="close" onclick="editGroup({{$recipientTeam->id }}, '{{ $recipientTeam->team->name }}')" data-toggle="modal" data-target="#editGroup"> <span class="glyphicon glyphicon-pencil size-12" title="Edit Recipient's Group" aria-hidden="true"></span></button>
								{{ $recipientTeam->team->name }}
							</div>
						</div>
					</div>
				@endforeach
				</form>
			</div>

			<br><br><br><br><br><br><br>

			<div class="panel panel-default col-lg-12">
				<h4><span class="glyphicon glyphicon-book"></span> Recipient's Contacts</h4>
				<br/>
				<form class="form-inline">
				@foreach ($rpt_nums as $rpt_num)
					<div class="form-group" style="margin-left: -1.5rem;">
						<div class="col-lg-12">
							<div class="alert alert-success col-lg-12" style="width: 105%; height: 5rem;" role="alert">
								<button type="button" class="close" onclick="deleteNum({{$rpt_num->id }})"  data-toggle="modal" data-target="#deleteNumModal"> <span class="glyphicon glyphicon-trash size-12" style="margin-left: 0.5rem;" title="Delete Recipient's Number" aria-hidden="true"  title="Delete Recipient's Number"></span></button>
								<button type="button" class="close" onclick="editNum({{$rpt_num->id }}, '{{ $rpt_num->phone_number }}', '{{ $rpt_num->provider }}')" data-toggle="modal" data-target="#editNum"> <span class="glyphicon glyphicon-pencil size-12" title="Edit Recipient's Number" aria-hidden="true"></span></button>
								{{ $rpt_num->phone_number }} - {{ $rpt_num->provider }}
							</div>
						</div>
					</div>
				@endforeach
				</form>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{!! Form::open(['route' => 'recipient.store']) !!}
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
					<a href="{{ URL('/')  }}/groups" class="btn btn-primary left" role="button"> Group not here? Click here.</a>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>


	<!-- Untag Modal -->
	<div class="modal fade" name="dlt" id="dlt" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true">
		{!! Form::open(['method'=>'DELETE', 'route' => 'recipientTeam.destroy']) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabels">Untag to Group</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center">
								<div class="form-group">
									<label class="col-md-12 control-label">Are you sure you want to untag {{ $recipient->name }} to <label id="name_textbox"></label>?</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('team_id', '', ['id'=>'id_textbox'] ) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Untag</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<!-- Delete Contact Modal -->
	<div class="modal fade" name="dlt" id="deleteNumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true">
		{!! Form::open(['method'=>'DELETE', 'route' => 'recipientNumber.destroy']) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabels">Delete Contact Number</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center col-lg-offset-1">
								<div class="form-group">
									<label class="col-md-12 control-label">Are you sure you want to delete this contact number?</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('num_id', '', ['id'=>'num_id_textbox'] ) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Delete</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<!-- Add Contact Modal -->
	<div class="modal fade" id="addContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{!! Form::open(['route' => 'recipientNumber.store']) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Contact Number</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center col-lg-offset-1">
								<div class="form-group">
									<label class="col-md-4 control-label">Phone Number</label>
									<div class="col-md-6">
										<input type="string" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
									</div>
								</div>
								<br/><br/><br/>
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
					{!! Form::hidden('rcpt_id', $recipient->id) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>


	<!-- Delete Recipient Modal -->
	<div class="modal fade" name="deleteRecipient" id="deleteRecipient" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true">
		{!! Form::open(['method'=>'DELETE', 'route'=>['recipient.destroy', $recipient->id]]) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabels">Delete Recipient</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center">
								<div class="form-group">
									<label class="col-md-12 control-label">Are you sure you want to Delete Recipient {{ $recipient->name }}</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('team_id', $recipient->id, [] ) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>


	<!-- Edit Name Modal -->
	<div class="modal fade" id="editName" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{!! Form::open(['method'=>'PATCH', 'route'=>['recipient.update', $recipient->id]]) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Change Recipient Name</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center col-lg-offset-1">
								<div class="form-group" style=" margin-top: -1.5rem;">
									<label class="col-md-4 control-label">Change Name</label>
									<div class="col-md-6">
										<input type="string" class="form-control" name="name" value="{{ $recipient->name }}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('rcpt_id', $recipient->id) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<!-- Edit Number Modal -->
	<div class="modal fade" id="editNum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{!! Form::open(['method'=>'PATCH', 'route'=>['recipientNumber.update']]) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Contact Number</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center col-lg-offset-1">
								<div class="form-group" style=" margin-top: -1.5rem;">
									<label class="col-md-4 control-label">Change Contact</label>
									<div class="col-md-6">
										<input type="string" id="rcpt_num" class="form-control" name="phone_number" value="">
									</div>
								</div>
								<br/><br/><br/>
								<div class="form-group" style=" margin-top: -1.5rem;">
									<label class="col-md-4 control-label">Change Provider</label>
									<div class="col-md-6">
										<input type="string" class="form-control" name="provider" id="rcpt_provider" value="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('rcp_id', '', ['id'=>'rc_nm_id']) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<!-- Edit Group Modal -->
	<div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{!! Form::open(['method'=>'PATCH', 'route'=>['recipientTeam.update']]) !!}
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Tagged Group</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 center col-lg-offset-1">
								<div class="form-group" style=" margin-top: -1.5rem;">
									<label class="col-md-4 control-label">Change Group</label>
									<div class="col-md-6">
										<div id="ch_group_list" name="team_id"></div>
									</div>
								</div>
								<br/><br/><br/>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('grp_id', '', ['id'=>'grp_id']) !!}
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
	function untagRecipient(id,name) {
		document.getElementById("id_textbox").value = id;
		document.getElementById('name_textbox').innerHTML = name;
	}

	function deleteNum(num_id) {
		document.getElementById("num_id_textbox").value = num_id;
	}

	function editNum(n_id, number, provider) {
		document.getElementById("rc_nm_id").value = n_id;
		document.getElementById("rcpt_num").value = number;
		document.getElementById("rcpt_provider").value = provider;
	}

	function editGroup(grp_id, grp_name) {
		document.getElementById("grp_id").value = grp_id;
		document.getElementById("grp_name").value = grp_name;
	}

	$.getJSON("{{ route('team.index') }}", function(data) {
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

		$('#ch_group_list').multilist({
			single: true,
			labelText: "Select Group",
			datalist: datalist,
			enableSearch: true,
		});
	});
</script>
@stop