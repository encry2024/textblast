<div class="col-lg-3">
    <br/>
    <div class="panel panel-default col-lg-12">
        <div class="panel-body left col-lg-12">
            <a href="{{ route('msg') }}"><span class="glyphicon glyphicon-comment"></span> Send SMS </a>
            <br/><br/>
            <a href="{{ url('stats/sms')  }}"><span class="glyphicon glyphicon-stats"></span> Stats </a>
            <hr>
            <a href="{{ url('sms/inbox') }}"><span class="glyphicon glyphicon-inbox"></span> Inbox </a>
            <br/><br/>
            <a href="{{ url('sms/outbox') }}"><span class="glyphicon glyphicon-tasks"></span> Outbox </a>
            <br/><br/>
            <a href="{{ url('sms/sent') }}"><span class="glyphicon glyphicon-share-alt"></span> Sent Items </a>
            <br/><br/>
            <a href="{{ url('sms/failed') }}"><span class="glyphicon glyphicon-exclamation-sign"></span> Failed Items </a>
            <hr>
            <a href="{{ route('pb')  }}"><span class="glyphicon glyphicon-book"></span> Contacts </a>
            <br/><br/>
            {{--<br><br>
            <a href=""><span class="glyphicon glyphicon-user"></span> Manage Users <span class="badge">0</span></a>--}}
            <a href="{{ route('grp') }}"><span class="glyphicon glyphicon-list-alt"></span> Groups </a>
            <div></div>
           {{-- <br/>
            <div class="sprtr"></div>
            <br/>
            <a href="#"><span class="glyphicon glyphicon-envelope"></span> Unread Messages <span class="badge">0</span></a>--}}
        </div>
    </div>
</div>