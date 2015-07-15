<div class="col-lg-3">
    <br/>
    <div class="panel panel-default col-lg-12">
        <div class="panel-body left col-lg-12">
            @if(Auth::user()->can('send-sms'))
            <a href="{{ route('msg') }}"><span class="glyphicon glyphicon-comment"></span> Send SMS </a>
            <br/><br/>
            @endif
            <a href="{{ url('stats/sms')  }}"><span class="glyphicon glyphicon-stats"></span> Stats </a>
            <hr>
            <a href="{{ url('sms/inbox') }}"><span class="glyphicon glyphicon-inbox"></span> Inbox {!! \App\Sms::getCountUnreadSms()>0?'<span class="badge">' .\App\Sms::getCountUnreadSms().'</span>':''  !!}</a>
            <br/><br/>
            <a href="{{ url('sms/outbox') }}"><span class="glyphicon glyphicon-tasks"></span> Outbox {!! \App\SmsActivity::getCountPendingSms()>0?'<span class="badge">' .\App\SmsActivity::getCountPendingSms().'</span>':''  !!}</a>
            <br/><br/>
            <a href="{{ url('sms/sent') }}"><span class="glyphicon glyphicon-share-alt"></span> Sent Items </a>
            <br/><br/>
            <a href="{{ url('sms/failed') }}"><span class="glyphicon glyphicon-exclamation-sign"></span> Failed Items {!! \App\SmsActivity::getCountFailedSms()>0?'<span class="badge">' .\App\SmsActivity::getCountFailedSms().'</span>':''  !!}</a>
            @if(Auth::user()->can('edit-contact'))
            <hr>
            <a href="{{ route('pb')  }}"><span class="glyphicon glyphicon-book"></span> Contacts </a>
            <br/><br/>
            <a href="{{ route('grp') }}"><span class="glyphicon glyphicon-list-alt"></span> Groups </a>
            @endif
        </div>
    </div>
</div>