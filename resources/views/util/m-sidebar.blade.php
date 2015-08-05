<div class="col-lg-2">
	<div class="btn-toolbar" role="toolbar" aria-label="...">
		<div class="btn-group-vertical " role="group" aria-label="..." style=" right: -5.4rem;">
			<a style=" border-top-right-radius: 0px; " data-toggle="popover" data-html="true" data-content="Messaging" data-container="body" class="ss_status_util btn btn-default" role="button" href="{{ url('messaging') }}"><span class="glyphicon glyphicon-comment size-28"></span> <br>Messaging</a>
			<a data-toggle="popover" data-html="true" data-content="Contacts" data-container="body" class="sms_status_util btn btn-default" role="button" href="{{ url('contacts') }}"><span class="glyphicon glyphicon-phone-alt size-28"></span> <br>Contacts</a>
			@if(Auth::user()->hasRole('admin'))
			<a data-toggle="popover" data-html="true" data-content="Users" data-container="body" class="sms_status_util btn btn-default" role="button" href="{{ url('user') }}"><span class="glyphicon glyphicon-user size-28"></span> <br>Users</a>
			@endif
			<a data-toggle="popover" data-html="true" data-content="SMS stats" data-container="body" class="sms_status_util btn btn-default" role="button" href="{{ url('stats/sms')  }}"><span class="glyphicon glyphicon-stats size-28"></span> <br>Stats</a>
			<a style=" border-bottom-right-radius: 0px; " data-toggle="popover" data-html="true" data-content="Log Out" data-container="body" class="sms_status_util btn btn-default" role="button" href="{{ url('auth/logout') }}"><span class="glyphicon glyphicon-log-out size-28"></span> <br>Log Out</a>
		</div>
		<!-- <div class="btn-group" role="group" aria-label="...">...</div> -->
	</div>
</div>
