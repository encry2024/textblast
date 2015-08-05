@extends('...app')

@section('header')
	@include('...util.m-topbar')
@stop

@section('content')
<div class="container">
    @include('...util.m-sidebar')
    <div class="col-lg-10">
        <div class="panel panel-default col-lg-12" style="border-top-left-radius: 0px;">
            <div class="page-header">
                <h3>Messaging > Outbox<span class="right"><a href="{{ url('sms/send') }}" type="button" class="btn btn-success size-12"><span class="glyphicon glyphicon-plus"></span> Send SMS</a></span></h3>
            </div>
            <br/>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="{{ url('messaging') }}"><span class="glyphicon glyphicon-inbox"></span> Inbox</a></li>
                <li role="presentation"><a href="{{ url('sms/sent') }}"><span class="glyphicon glyphicon-share-alt"></span> Sent</a></li>
                <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-tasks"></span> Sending</a></li>
                <li role="presentation"><a href="{{ url('sms/failed') }}"><span class="glyphicon glyphicon-exclamation-sign"></span> Failed</a></li>
            </ul>
            <table id="messages" class="table">
                <tr>
                    <th></th>
                    <th>SMS ID</th>
                    <th>Message</th>
                    <th>Sender</th>
                    <th>Date</th>
                </tr>
                <?php $count = $messages->firstItem() ?>
                @foreach($messages as $sms)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $sms->sms->id }}</td>
                        <td>
                            <a href="{{ url('sms/'.$sms->sms->id.'/edit') }}">{{ strlen($sms->sms->message)>30?substr($sms->sms->message, 0, 27) . '...':$sms->sms->message }}</a>
                        </td>
                        <td>{{ $sms->user->name }}</td>
                        <td>{{ $sms->created_at }}</td>
                    </tr>
                @endforeach
            </table>
            {!! $messages->render() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

</script>
@stop