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
    @include('util.m-sidebar')
    <div class="col-lg-9 col-md-offset-center-2">
    <br/>
        <div class="panel panel-default col-lg-12">
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-inbox"></span> Inbox</h3>
           </div>
           <br/>
           <table id="messages" class="table"></table>
           <br/><br/>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	var choices = [];
	$(document).ready(function() {
		$("#ui-id-1").empty();
		$("#myTags").tagit({
			autocomplete: {
			delay: 0,
			minLength: 2,
			source: function(search, showChoices) {
				$.getJSON("{{ route('team.index') }}", {q: search.term},
					function (data) {
						$.each(data, function (idx, tag) {
							choices.push(tag.name, tag.id);
							$("#myTags").data(tag.name, tag.id);
						});
						showChoices(choices);
					});
				}

			},
			showAutocompleteOnFocus: true,
			allowSpaces: true,
			removeConfirmation: true,
			fieldName: "receivers[]"
		});
	});

	$.getJSON("sms", function(data) {
		$('#messages').dataTable({
			"aaData": data,
			"aaSorting": [],
			"oLanguage": {
			    "sEmptyTable": "There are currently no messages...",
				"sLengthMenu": "per Messages _MENU_",
				"oPaginate": {
				"sFirst": "First ", // This is the link to the first
				"sPrevious": "&#8592; Previous", // This is the link to the previous
				"sNext": "Next &#8594;", // This is the link to the next
				"sLast": "Last " // This is the link to the last
				}
			},
			//DISPLAYS THE VALUE
			"aoColumns":
			[
				{"sTitle": "#", "mDataProp": "id"},
				{"sTitle": "Message", "mDataProp": "msg"},
				{"sTitle": "Type (Sent/Received)", "mDataProp": "type"},
				{"sTitle": "Recipients", "mDataProp": "recipients"},
				{"sTitle": "Date Sent/Received", "mDataProp": "created_at"},
			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
						return "<label>SMS" + data + "</label>";
					}
				},
				{
					"aTargets": [ 1 ], // Column to target
					"width": "40%",
					"mRender": function ( data, type, full ) {
						var url = '{{ route('sms.edit', ":id") }}';
						url = url.replace(':id', full["id"]);
						if(data.length > 50) {
							data = data.substr(0, 50) + '...';
						}
						return "<a href='"+ url +"' class='size-14 text-left'>" + data + "</a>";
					}
				},
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
					return '<label class="text-center size-14"> ' + data + ' </label>';
					}
				},
				{
					"aTargets": [ 3 ], // Column to target
					"mRender": function ( data, type, full ) {
						return '<label class="text-center size-14"> ' + data + ' </label>';
					}
				},
		        {
                    "aTargets": [ 4 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    return '<label class="text-center size-14"> ' + data + ' </label>';
                    }
                }
			]
		});
	$('div.dataTables_filter input').attr('placeholder', 'Filter Date');
});
</script>
@stop