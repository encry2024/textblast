<nav class="navbar navbar-default point-border" style="border-radius: 0px;">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ route('/home') }}">
				<span><img alt="Brand" style=" margin-top: -1rem; margin-left: 2rem;" src="{!! URL::to('/') !!}/assets/img/nsi3.png"></span>
			</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					Logged in as :: {!! Auth::user()->name !!} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{!! URL::to('/') !!}/user"><span class="glyphicon glyphicon-user"></span> Registered Users</a></li>
						<li><a href="{!! URL::to('/') !!}/auth/register"><span class="glyphicon glyphicon-pencil"></span> Sign up User</a></li>
						<li><a href="{{ route('activity.index') }}"><span class="glyphicon glyphicon-book"></span> History</a></li>
						<li><a href="{{ route('change_password') }}"><span class="glyphicon glyphicon-refresh"></span> Change Password</a></li>
						<li class="divider"></li>
						<li><a href="{!! URL::to('/') !!}/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</li>
				 <li><a href="{!! URL::to('/') !!}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>



<div class="btn-toolbar right" role="toolbar" aria-label="...">
	<div class="btn-group-vertical" role="group" aria-label="..." style=" margin-bottom: -11.5rem; margin-right: 6.5rem; ">
		<a href="" data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\Sms::getCountUnreadSms() }}</kbd> Unread SMS " data-container="body" class="sms_status_util btn
		{{ \App\Sms::getCountUnreadSms()>0 ? "btn-primary" : "btn-default" }}
		" role="button"><span class="glyphicon glyphicon-envelope"></span>
		</a>

		<a href="" data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\SmsActivity::getCountPendingSms() }}</kbd> SMS on Queue" data-container="body"  class="sms_status_util btn
		 {{  \App\SmsActivity::getCountPendingSms()>0 ? "btn-info" : "btn-default"  }}
		 glyphicon glyphicon-refresh" role="button" >
		</a>

		<a href="" data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\SmsActivity::getCountFailedSms() }}</kbd> Failed SMS" data-container="body" class="sms_status_util btn
		{{ \App\SmsActivity::getCountFailedSms()>0 ? "btn-danger" : "btn-default" }}
		" role="button"><span class="glyphicon glyphicon-exclamation-sign"></span>
		</a>
	</div>
	<!-- <div class="btn-group" role="group" aria-label="...">...</div> -->
</div>