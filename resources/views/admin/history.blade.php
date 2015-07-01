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
			<div class="page-header">
				<h3><span class="glyphicon glyphicon-user"></span> History</h3>
			</div>
			<br/>
			<table id="history" class="table"></table>
			<br/><br/>
		</div>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
	$.getJSON("{{ route('get_history') }}", function(data) {
		$('#history').dataTable({
			"aaData": data,
			"aaSorting": [],
			"oLanguage": {
				"sEmptyTable": "There are currently no User registered...",
				"sLengthMenu": "per User _MENU_",
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
				{"sTitle": "#", "width":"5%" ,"mDataProp": "event_id"},
				{"sTitle": "User", "mDataProp": "user_name"},
				{"sTitle": "Event", "mDataProp": "event_name"},
				{"sTitle": "Date", "mDataProp": "created_at"},
			],

			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
						return "<label>" + data + "</label>";
					}
				},
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
						var url = '{{ route('user.show', ":id") }}';
						url = url.replace(':id', full["user_id"]);
						return "<a href='"+ url +"' class='size-14 text-left'>" + data + "</a>";
					}
				},
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
						return '<label class="size-14 text-left"> ' + data + ' </label>';
					}
				}
			]
		});
		$('div.dataTables_filter input').attr('placeholder', 'Filter User');
	});
</script>
@stop