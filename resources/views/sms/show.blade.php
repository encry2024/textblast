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

	<div class="col-lg-3">
		<div class="panel panel-default col-lg-12">
			<div class="panel-body">
				<a href="#" class="col-lg-12" data-toggle="modal" data-target="#templateModal"><span class="glyphicon glyphicon-plus" ></span> Create Template</a>
				<br><br><br><br>
				<a href="{{route('/home') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Home</a>
			</div>
		</div>
	</div>
	{!! Form::open([ 'url' => 'sms/send', 'files' => true ]) !!}
	<div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
		   <div class="page-header">
				<h3><span class="glyphicon glyphicon-comment"></span> Send Messages</h3>
		   </div>
			<div class="form-group">
				<label for="recipient-name" class="control-label">Recipient:</label>
				<input type="text" id="txt" name="tags[]"/>
				{!! Form::file('smsNumbersFile', null) !!}
			</div>
			<br/>
			<div id="stts_tag" role="status"><span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"><div></div></span></div>
			<div class="form-group">
				<label for="message-text" class="control-label">Templates:</label>
				<select name="template" id="template">
				<option value="" class="form-control">Select a Template</option>
				@foreach ($templates as $template)
					<option value="{{ $template->id }}" class="form-control">{{ $template->name }}</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="message-text" class="control-label">Message:</label>
				<textarea name="message" rows="10" class="form-control" id="message_text"></textarea>
			</div>
			<div class="right">
			<button type="submit" class="btn btn-primary">Send message <span class="glyphicon glyphicon-send size-12"></span> </button>
		   </div>
		   <br/><br/>
		</div>
	</div>
	{!! Form::close() !!}
</div>

<!-- CREATE TEMPLATE MODAL -->
<div class="modal fade large" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Template</h4>
			</div>
			{!! Form::open(['route' => 'template.store']) !!}
			<div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 center col-lg-offset-1">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Template Name</label>
                                <div class="col-md-6">
                                    <input type="string" class="form-control" id="template" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <br/><br/>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Template</label>
                                <div class="col-md-6">
                                    <textarea rows="10" type="string" class="form-control" name="view" value="{{ old('view') }}"></textarea>
                                </div>
                            </div>
                            <br/><br/>
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
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$("body").on('change', '#template', function() {
            //get the selected value
            var selectedValue = $(this).val();

            //make the ajax call
            $.ajax({
                url: "{!! URL::to('/') !!}/template/"+selectedValue,
                type: 'GET',
                data: {option : selectedValue},
                success: function(data) {
                    document.getElementById("message_text").value = data.view;
                }
            });
        });


		//The demo tag array
		var availableTags = [];
		$.getJSON("{!! URL::to('/') !!}/mobile-numbers/json", function(data) {
			$.each(data, function(key, val) {
				availableTags.push({label:val, id:key+'-R'});
			});
		});

		$.getJSON("{!! URL::to('/') !!}/teams/json", function(data) {
			$.each(data, function(key, val) {
				availableTags.push({label:val, id:key+'-T'});
			});
		});

		//The text input
		var input = $("input#txt");

		//The tagit list
		var instance = $("<ul class=\"tags\" id=\"recipients\"></ul>");

		//Store the current tags
		//Note: the tags here can be split by any of the trigger keys
		//      as tagit will split on the trigger keys anything passed
		var currentTags = input.val();

		//Hide the input and append tagit to the dom
		input.hide().after(instance);

		//Initialize tagit
		instance.tagit({
			tagSource:availableTags,
			fieldName: "receivers[]",
			allowSpaces: true,
			removeConfirmation: true,
			afterTagAdded: function(event, ui) {
				// do something special
				result = $.grep(availableTags, function(e){ return e.label == ui.tagLabel; });
				$("input[value*='"+ui.tagLabel+"']").val(result[0].id);
			}
		});
	});
</script>
@stop
