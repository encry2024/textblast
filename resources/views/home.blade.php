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
                <h3><span class="glyphicon glyphicon-inbox"></span> Inbox <span class="right"><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-pencil"></span> Compose SMS</a></span></h3>
           </div>
           <table id="messages" class="table"></table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$.getJSON("sms", function(data) {
		$('#messages').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"aaSorting": [[ 4, 'desc' ]],
			"oLanguage": {
			    "sEmptyTable":     "There are currently no messages...",
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
				{"sTitle": "Name", "sWidth": "20%", "mDataProp": "id"},
				{"sTitle": "Message", "sWidth": "20%", "mDataProp": "msg"},
				{"sTitle": "Recipient Type", "sWidth": "15%", "mDataProp": "msg_type"},
				{"sTitle": "SMS Type", "sWidth": "15%", "mDataProp": "type"},
				{"sTitle": "Received/Sent", "sWidth": "15%", "mDataProp": "received"},
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
						return "<a href='#' class='size-14 text-left'>" + full["id"] + "</a>";
					}
				},
                //CATEGORY RECENT UPDATE
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["msg"] + ' </label>';
					}
				},
		        {
                    "aTargets": [ 2 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["msg_type"] + ' </label>';
                    }
                },
                {
                    "aTargets": [ 3 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["type"] + ' </label>';
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