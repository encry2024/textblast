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
         <h2>{{ count($inbox) }} Msgs</h2>
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-inbox"></span> Inbox <span class="right"><a href="#" class="btn btn-primary" role="button" data-toggle="modal" data-target="#composeSms"><span class="glyphicon glyphicon-pencil"></span> Compose SMS</a></span></h3>
           </div>
           <table id="messages" class="table"></table>
        </div>
    </div>
</div>


<!-- Compose SMS Modal -->
<div class="modal fade" id="composeSms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
{!! Form::open([ 'route'=>['sms.store'] ]) !!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Compose SMS</h4>
			</div>
			<div class="modal-body">

				<form>
					<div class="form-group">
						<label for="recipient-name" class="control-label">Recipient:</label>
						<ul id="myTags" name="itemName"></ul>
					</div>
					<div id="stts_tag" role="status"><span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"><div></div></span></div>
					<div class="form-group">
						<label for="message-text" class="control-label">Message:</label>
						<textarea name="message" rows="10" class="form-control" id="message-text"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Send message <span class="glyphicon glyphicon-send size-12"></span> </button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@endsection

@section('script')
<script type="text/javascript">
	var choices = [];
	$(document).ready(function() {
		$("#ui-id-1").empty();
		$("#myTags").tagit({
			autocomplete: {
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
			allowSpaces: true,
			removeConfirmation: true,
			fieldName: "receiver[]"
		});
	});

	$.getJSON("sms", function(data) {
		$('#messages').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"aaSorting": [[ 4, 'desc' ]],
			"oLanguage": {
			    "sEmptyTable": "There are currently no messages...",
				"sLengthMenu": "per MSGS _MENU_",
				"oPaginate": {
				"sFirst": "First ", // This is the link to the first
				"sPrevious": "&#8592; Previous", // This is the link to the previous
				"sNext": "Next &#8594;", // This is the link to the next
				"sLast": "Last " // This is the link to the last
				}
			},
			//DISPLAYS THE VALUE
			//sTITLE - HEADER
			//MDATAPROP - TBODY
			"aoColumns":
			[
				{"sTitle": "id", "sWidth": "0%", "mDataProp": "id"},
				{"sTitle": "Recipient", "sWidth": "30%", "mDataProp": "name"},
				{"sTitle": "Message", "sWidth": "20%", "mDataProp": "msg"},
				{"sTitle": "Recipient Type", "sWidth": "25%", "mDataProp": "msg_type"},
				{"sTitle": "Received At", "sWidth": "20%", "mDataProp": "received"},
			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				//ID
				//CATEGORY SLUG
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
					    {{--var url = '{{ route('category_path/show', ":slug") }}';--}}
					    {{--url = url.replace(':slug', full["slug"]);--}}
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='#' class='size-14 text-left'>" + data + "</a>";
					}
				},
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						{{--var url = '{{ route('category_path/show', ":slug") }}';--}}
						{{--url = url.replace(':slug', full["slug"]);--}}
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='#' class='size-14 text-left'>" + full["name"] + "</a>";
					}
				},
                //CATEGORY RECENT UPDATE
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["msg"] + ' </label>';
					}
				},
		        {
                    "aTargets": [ 3 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["msg_type"] + ' </label>';
                    }
                },
				{
                    "aTargets": [ 4 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["received"] + ' </label>';
                    }
                },
			],

			/*"fnDrawCallback": function( oSettings ) {
				*//* Need to redo the counters if filtered or sorted *//*
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( "<label>" + (i+1) + "</label>" );
					}
				}
			}*/
		});
	$('div.dataTables_filter input').attr('placeholder', 'Filter Date');
});
</script>
@stop