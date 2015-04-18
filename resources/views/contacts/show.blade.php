@extends('app')

@section('header')
    @include('util.m-topbar')
@stop

@section('content')
<div class="container">
    <div class="col-lg-3">
        <br/>
        <div class="panel panel-default col-lg-12">
            <div class="panel-body left">
                <a href="{{ route('') }}" class="btn btn-primary col-lg-12" role="button"><span class="glyphicon glyphicon-plus"></span> Add Contact</a>
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
    <br/>
        <div class="panel panel-default col-lg-12">
           <div class="page-header">
                <h3><span class="glyphicon glyphicon-book"></span> Contacts</h3>
           </div>
           <table id="contacts" class="table"></table>
        </div>
    </div>
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
				{"sTitle": "Name", "sWidth": "20%", "mDataProp": "name"},
				{"sTitle": "Number", "sWidth": "20%","mDataProp": "recipient_number"},
				{"sTitle": "Group Name", "sWidth": "20%","mDataProp": "group_name"},
				{"sTitle": "Provider", "sWidth": "20%","mDataProp": "provider"},
				{"sTitle": "Recent Updates", "sWidth": "20%","mDataProp": "updated_at"},
			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				// RECIPIENT NAME
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
					    {{--var url = '{{ route('category_path/show', ":slug") }}';--}}
					    {{--url = url.replace(':slug', full["slug"]);--}}
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='#' class='size-14 text-left'>" + full["name"] + "</a>";
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
				// RECIPIENT'S GROUP NAME
                {
                    "aTargets": [ 2 ], // Column to target
                        "mRender": function ( data, type, full ) {
                        // 'full' is the row's data object, and 'data' is this column's data
                        // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                        return '<label class="text-center size-14"> ' + full["group_name"] + ' </label>';
                        }
                },
                // RECIPIENT'S PROVIDER
		        {
                    "aTargets": [ 3 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["provider"] + ' </label>';
                    }
                },
                // CHANGES ON RECIPIENT
                {
                    "aTargets": [ 4 ], // Column to target
                    "mRender": function ( data, type, full ) {
                    // 'full' is the row's data object, and 'data' is this column's data
                    // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                    return '<label class="text-center size-14"> ' + full["updated_at"] + ' </label>';
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