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
                <h3><span class="glyphicon glyphicon-envelope"></span> Inbox</h3>
           </div>
           <table id="messages" class="table"></table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$.getJSON("recipient", function(data) {
		$('#messages').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"aaSorting": [[ 2, 'asc' ]],
			"oLanguage": {
				"sLengthMenu": "No. of MSGS _MENU_",
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
				{"sTitle": "#", "mDataProp": "id", "sWidth": "100px","sClass": "size-14"},
				{"sTitle": "Name", "sWidth": "100px", "mDataProp": "name"},
				{"sTitle": "Number", "sWidth": "100px","mDataProp": "updated_at"},
				{"sTitle": "Message", "sWidth": "100px","mDataProp": "updated_at"},

			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				//ID
				{ "bSortable": false, "aTargets": [ 0 ] },
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14">' + data + '</label>';
					}
				},
				//CATEGORY SLUG
				{
					"aTargets": [ 1 ], // Column to target
					"mRender": function ( data, type, full ) {
					    var url = '{{ route('category_path/show', ":slug") }}';
					    url = url.replace(':slug', full["slug"]);
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='" + url + "' class='size-14 text-left'>" + full["name"] + "</a>";
					}
				},
                //CATEGORY RECENT UPDATE
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
					// 'full' is the row's data object, and 'data' is this column's data
					// e.g. 'full[0]' is the comic id, and 'data' is the comic title
					return '<label class="text-center size-14"> ' + full["updated_at"] + ' </label>';
					}
				},
			],

			"fnDrawCallback": function( oSettings ) {
				/* Need to redo the counters if filtered or sorted */
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( "<label>" + (i+1) + "</label>" );
					}
				}
			}
		});
	$('div.dataTables_filter input').attr('placeholder', 'Filter Categories');
});
</script>
@stop