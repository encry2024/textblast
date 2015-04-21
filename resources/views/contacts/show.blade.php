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
			<div class="panel-body left">
				<a href="#" class="btn btn-primary col-lg-12" role="button" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Add Contact</a>
				<br/><br/>
				<a href="#" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-th-list"></span> Add to Group</a>
				<div></div>
				<br/><br/>
				<div class="sprtr"></div>
				<br/>
				<a href="{{route('/home') }}" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-menu-left" ></span> Back to Home</a>
			</div>
		</div>
	</div>
	<div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
		   <div class="page-header">
				<h3><span class="glyphicon glyphicon-book"></span> Contacts</h3>
		   </div>
		   <br/><br/>
		   <table id="contacts" class="table"></table>
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
@stop

@section('script')
<script type="text/javascript">
	$.getJSON("recipients", function(data) {
		$('#contacts').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"oLanguage": {
				"sEmptyTable": "No contacts to be shown...",
				"sLengthMenu": "No. of Contacts _MENU_",
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
				{"sTitle": "Name", "sWidth": "15%", "mDataProp": "name"},
				{"sTitle": "Number", "sWidth": "6%","mDataProp": "recipient_number"},
				{"sTitle": "Provider", "sWidth": "5%","mDataProp": "provider"},
				{"sTitle": "Recent Update", "sWidth": "15%","mDataProp": "recent_updates"},
			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				// RECIPIENT NAME
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
						var url = '{{ route('recipient/show', ":id") }}';
						url = url.replace(':id', full["id"]);
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='  " + url + "' class='size-14 text-left'>" + full["name"] + "</a>";
					}
				},
				// RECIPIENT PHONE NUMBER
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["recipient_number"] + ' </label>';
					}
				},
				// RECIPIENT'S PROVIDER
				{
                    "aTargets": [ 2 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["provider"] + ' </label>';
                    }
                },
				// RECIPIENT'S GROUP NAME
				{
					"aTargets": [ 3 ], // Column to target
						"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="text-center size-14"> ' + full["recent_updates"] + ' </label>';
						}
				},
				// CHANGES ON RECIPIENT
				/*{
					"aTargets": [ 4 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["updated_at"] + ' </label>';
					}
				},*/
			]
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