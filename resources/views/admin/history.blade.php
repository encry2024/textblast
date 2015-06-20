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
	$.getJSON("{{ route('audit') }}", function(data) {
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
				{"sTitle": "#", "mDataProp": "user_id"},
				{"sTitle": "User", "mDataProp": "user_name"},
				{"sTitle": "Type", "mDataProp": "user_type"},
				{"sTitle": "E-mail", "mDataProp": "user_email"},
				{"sTitle": "Status", "mDataProp": "user_status"},
				{"sTitle": "Recent Update", "mDataProp": "updated_at"},
			],

			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
						return "<label>USER-" + data + "</label>";
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
				},
				{
					"aTargets": [ 5 ], // Column to target
					"mRender": function ( data, type, full ) {
						return '<label class="text-center size-14"> ' + data + ' </label>';
					}
				}
			]
		});
		$('div.dataTables_filter input').attr('placeholder', 'Filter User');
	});
</script>
@stop