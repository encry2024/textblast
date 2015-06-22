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
           <br/>
           <table id="messages" class="table"></table>
           <br/><br/>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$.getJSON("{{ url() }}/sms/status/FAILED", function(data) {
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
						{"sTitle": "Recipient", "width":"30%","mDataProp": "recipient"},
						{"sTitle": "Created Date", "width":"10%","mDataProp": "created_at"},
					],
			"aoColumnDefs":
					[
						//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
						{
							"aTargets": [ 0 ], // Column to target
							"mRender": function ( data, type, full ) {
								return "<label>SMS-" + data + "</label>";
							}
						},
						{
							"aTargets": [ 1 ], // Column to target
							"mRender": function ( data, type, full ) {
								var url = '{{ route('sms.edit', ":id") }}';
								url = url.replace(':id', full["id"]);
								return "<a href='"+ url +"' class='size-14 text-left' data-popover='true' data-html='true' data-trigger='hover' data-content='" + full["full_msg"] + "'>" + data + "</a>";
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
						}
					]
		});
		$('div.dataTables_filter input').attr('placeholder', 'Filter Date');
	});

	$('body').popover({ selector: '[data-popover]', trigger: 'hover', placement: 'right', delay: {show: 50, hide: 50}});
</script>
@stop