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
	@if (count($errors) > 0)
		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@include('util.m-sidebar')
	<div class="col-lg-10">
		<div class="panel panel-default col-lg-12" style="border-top-left-radius: 0px;">
			<div class="page-header">
				<h3>Contacts > Contacts<span class="right"><button type="button" class="btn btn-success size-12" data-toggle="modal" data-target="#recipientModal"><span class="glyphicon glyphicon-plus"></span> Add Contact</button></span></h3>
			</div>
			<br/>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-book"></span> Contacts</a></li>
				<li role="presentation"><a href="{{ url('groups') }}"><span class="glyphicon glyphicon-list-alt"></span> Groups</a></li>
			</ul>
		   <br/><br/>
		   <table id="contacts" class="table"></table>
		   <br/>
		</div>
	</div>
</div>

<!-- Recipient Modal -->
<div class="modal fade" id="recipientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {!! Form::open(['route' => 'recipient.store']) !!}
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
	$.getJSON("recipient", function(data) {
		console.log(data);
		$('#contacts').dataTable({
			"aaData": data,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"oLanguage": {
				"sEmptyTable": "No contacts to be shown...",
				"sLengthMenu": "Per Contacts _MENU_",
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
				{"sTitle": "Phones", "sWidth": "15%", "mDataProp": "phone"},
				{"sTitle": "Recent Update", "sWidth": "15%","mDataProp": "recent_updates"},
			],
			"aoColumnDefs":
			[
				//FORMAT THE VALUES THAT IS DISPLAYED ON mDataProp
				// RECIPIENT NAME
				{
					"aTargets": [ 0 ], // Column to target
					"mRender": function ( data, type, full ) {
						var url = '{{ route('recipient.show', ":id") }}';
						url = url.replace(':id', full["id"]);
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return "<a href='" + url + "' class='size-14 text-left'>" + full["name"] + "</a>";
					}
				},
				{
					"aTargets": [ 1 ], // Column to target
						"mRender": function ( data, type, full ) {
							var phones = '';
							full["phones"].forEach(function(entry) {
								phones += entry["phone_number"] +  ",";
							});

							phones = phones.substr(0, phones.length - 1);

						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="text-center size-14"> ' + phones + ' </label>';
						}
				},

				// RECIPIENT'S GROUP NAME
				{
					"aTargets": [ 2 ], // Column to target
					"mRender": function ( data, type, full ) {
						// 'full' is the row's data object, and 'data' is this column's data
						// e.g. 'full[0]' is the comic id, and 'data' is the comic title
						return '<label class="text-center size-14"> ' + full["recent_updates"] + ' </label>';
					}
				}
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
		});
	$('div.dataTables_filter input').attr('placeholder', 'Filter Date');
});
</script>
@stop