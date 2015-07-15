
<div class="col-lg-1">
	<div class="btn-toolbar" role="toolbar" aria-label="...">
		<div class="btn-group-vertical" role="group" aria-label="..." style=" right: -5.4rem;">
			<a style=" border-top-right-radius: 0px; " data-toggle="popover" data-html="true" data-content="Send Messages" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ route('msg') }}"><span class="glyphicon glyphicon-comment size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="SMS stats" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ url('stats/sms')  }}"><span class="glyphicon glyphicon-stats size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\Sms::getCountInbox() }}</kbd> Inbox" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ url('sms/inbox') }}"><span class="glyphicon glyphicon-inbox size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\SmsActivity::getCountSentSms() }}</kbd> Sent Messages" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ url('sms/sent') }}"><span class="glyphicon glyphicon-share-alt size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ count(\App\Recipient::all()) }}</kbd> Recipients" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ route('pb')  }}"><span class="glyphicon glyphicon-book size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ count(\App\Team::all()) }}</kbd> Group" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ route('grp') }}"><span class="glyphicon glyphicon-list-alt size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ count(\App\Activity::all()) }}</kbd> Record Events" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ route('activity.index') }}"><span class="glyphicon glyphicon-bookmark size-20"></span></a>
			<a data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\SmsActivity::getCountPendingSms() }}</kbd> SMS on Queue" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ url('sms/outbox') }}"><span class="glyphicon glyphicon-tasks size-20"></span></a>
			<a href="{{ url('sms/inbox') }}" data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\Sms::getCountUnreadSms() }}</kbd> Unread SMS " data-container="body" class="sms_status_util btn btn-success" role="button"><span class="glyphicon glyphicon-envelope size-20"></span></a>
			<a style=" border-bottom-right-radius: 0px; " data-toggle="popover" data-html="true" data-content="<kbd>{{ \App\SmsActivity::getCountFailedSms() }}</kbd> Failed SMS" data-container="body" class="sms_status_util btn btn-success" role="button" href="{{ url('sms/failed') }}"><span class="glyphicon glyphicon-exclamation-sign size-20"></span></a>
		</div>
		<!-- <div class="btn-group" role="group" aria-label="...">...</div> -->
	</div>
</div>
