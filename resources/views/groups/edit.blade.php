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
		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{!! Form::open(array('url'=>'tag/recipient')) !!}
	<div class="col-lg-3">
		<div class="panel panel-default col-lg-12">
			<div class="panel-body">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save Changes</button>
				<br/><br/>
				<div class="sprtr"></div>
				<br/>
				<a href="#" class="col-lg-12" data-toggle="modal" data-target="#recipientModal"><span class="glyphicon glyphicon-trash"></span> Delete this Group</a>
				<br/><br/><br/><br/><br/><br/><br/>
				<a href="{{ route('grp') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Home</a>
			</div>
		</div>
	</div>

	<div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
		   <div class="page-header">
				<h3>{{ $id->name }} <a href="#" title="Edit Group's Name" data-toggle="modal" data-target="#editName"><span class="glyphicon glyphicon-pencil size-12" style="top: -1.5rem;"></span></a></h3>
		   </div>
			<div class="form-group">
				<label class="col-md-4 control-label">Description</label>
				<div class="col-md-5">
					<textarea rows="5" cols="40" type="string" class="form-control" name="description">{{ $id->description }}</textarea>
				</div>
				<br/><br/><br/><br/><br/><br/>
			</div>
		</div>

		<div class="panel panel-default col-lg-12">
			<h4><span class="glyphicon glyphicon-tag"></span> Tag a Recipient</h4>
			<br/><br/>
			<div class="form-group">
				<label class="col-md-4 control-label" style="margin-left: -1.5rem;">Search Recipient to Tag</label>
				<input type="text" id="txt" name="tags"/>
			</div>
			{!! Form::hidden('team_id', $id->id) !!}
	{!! Form::close() !!}
			<br/>
			<label for="" class="col-md-4 control-label" >Tagged Recipient</label>
			<div class="col-lg-12">
				<br/>
				<form class="form-inline">
				@foreach ($id->recipients as $recipientTeam)
					<div class="form-group" style="margin-left: -1.5rem;">
						<div class="col-lg-12">
							<div class="alert alert-success col-lg-12" style="width: 105%; height: 5rem;" role="alert">
								<button type="button" class="close" onclick="untagRecipient( {{ $recipientTeam->id }}, '{{ $recipientTeam->name }}' )" data-toggle="modal" data-target="#untagRecipient" title="Untag recipient from the group"> <span class="glyphicon glyphicon-trash size-12" aria-hidden="true" style="margin-left: 0.5rem;"> </span></button>
								{{ $recipientTeam->name }}
							</div>
						</div>
					</div>
				@endforeach
				</form>
			</div>
		</div>
	</div>
	
</div>
	<!-- Untag Modal -->
	<div class="modal fade" name="untagRecipient" id="untagRecipient" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true">
		{!! Form::open(array('url'=>'delete/recipient')) !!}
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
									<label class="col-md-12 control-label">Are you sure you want to untag <label id="rn_textbox"></label> to {{$id->name}}?</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="modal-footer">
					{!! Form::hidden('team_id', $id->id) !!}
					{!! Form::hidden('recipient_id','' ,['id'=>'recipient_Id'])     !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Untag</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
@stop

@section('script')
<script type="text/javascript">
	function untagRecipient(id,r) {
		document.getElementById('recipient_Id').value = id;
		document.getElementById('rn_textbox').innerHTML = r;
	}

	$(document).ready(function() {
		//The demo tag array
		var availableTags = [];

		$.getJSON("{!! URL::to('/') !!}/retrieve/recipients", function(data) {
			$.each(data, function(key, val) {
				availableTags.push({label: val.dta, id: val.id});
			});
		});
		//The text input
		var input = $("input#txt")

		//The tagit list
		var instance = $("<ul class=\"tags\"></ul>");

		//Store the current tags
		//Note: the tags here can be split by any of the trigger keys
		//as tagit will split on the trigger keys anything passed
		var currentTags = input.val();

		//Hide the input and append tagit to the dom
		input.hide().after(instance);

		//Initialize tagit
		instance.tagit({
			tagSource:availableTags,
			fieldName: "receivers[]",
			allowSpaces: true,
			removeConfirmation: true,
			select: true,
			triggerKey: ['tab']
		});
	});
</script>
@stop