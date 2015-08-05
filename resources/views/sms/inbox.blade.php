@extends('...app')

@section('header')
	@include('...util.m-topbar')
@stop

@section('content')
	<div class="container">
		@include('...util.m-sidebar')
		<div class="col-lg-10">
			<div class="panel panel-default col-lg-12" style=" border-top-left-radius: 0px;">
				<div class="page-header">
					<h3>Messaging > Inbox<span class="right"><a href="{{ url('sms/send') }}" type="button" class="btn btn-success size-12"><span class="glyphicon glyphicon-plus"></span> Send SMS</a></span></h3>
				</div>
				<br/>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home"><span class="glyphicon glyphicon-inbox"></span> Inbox</a></li>
					<li role="presentation"><a href="{{ url('sms/sent') }}"><span class="glyphicon glyphicon-share-alt"></span> Sent</a></li>
					<li role="presentation"><a href="{{ url('sms/outbox') }}"><span class="glyphicon glyphicon-tasks"></span> Sending</a></li>
					<li role="presentation"><a href="{{ url('sms/failed') }}"><span class="glyphicon glyphicon-exclamation-sign"></span> Failed</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<br>
						<table id="messages" class="table"></table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$.getJSON("{{ url() }}/sms/getInbox", function(data) {
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
							{"sTitle": "Sender", "mDataProp": "sender"},
							{"sTitle": "Created Date", "mDataProp": "created_at"},
						],
				"aoColumnDefs":
						[
							//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
							{
								"aTargets": [ 0 ], // Column to target
								"width": "10%",
								"mRender": function ( data, type, full ) {
									return "<label>SMS-" + data + "</label>";
								}
							},
							{
								"aTargets": [ 1 ], // Column to target
								"width": "40%",
								"mRender": function ( data, type, full ) {
									var url = '{{ url('sms') }}';
									return "<a href='"+ url +"/"+ full["id"] + "/received' class='size-14 text-left'>" + data + "</a><br><hr><h6>Seen by: " + full['seen_by'] + "</h6>";
								}
							},
							{
								"aTargets": [ 2 ], // Column to target
								"mRender": function ( data, type, full ) {
									return '<label class="size-14 text-left"> ' + data + ' </label>';
								}
							},
							{
								"aTargets": [ 3 ], // Column to target
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