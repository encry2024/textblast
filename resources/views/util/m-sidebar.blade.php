<div class="col-lg-3">
    <br/>
    <div class="panel panel-default col-lg-12">
        <div class="panel-body left">
            <a href="{{ route('pb')  }}"><span class="glyphicon glyphicon-book"></span> Contacts <span class="badge">{{ count($recipients) }}</span></a>
            <br/><br/>
            <a href=""><span class="glyphicon glyphicon-share-alt"></span> Sent Messages <span class="badge"> {{ count($sent_msg) }} </span></a>
            <br><br>
            <a href=""><span class="glyphicon glyphicon-user"></span> Manage Users <span class="badge">0</span></a>
            <br><br>
            <a href="{{ route('grp') }}"><span class="glyphicon glyphicon-list-alt"></span> Manage Groups <span class="badge">{{ count($team) }}</span></a>
            <div></div>
            <br/>
            <div class="sprtr"></div>
            <br/>
            <a href="#"><span class="glyphicon glyphicon-envelope"></span> Unread Messages <span class="badge">0</span></a>
        </div>
    </div>
</div>