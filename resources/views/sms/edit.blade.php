@extends('app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
<div class="container">
	<div class="col-lg-3">
		<div class="panel panel-default col-lg-12">
			<div class="panel-body">
				<a href="{{ route('/home') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Sent SMS</a>
			</div>
		</div>
	</div>
    <div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
			<div class="page-header">
				<h3><span class="glyphicon glyphicon-send"></span> Sent To <span class="right"><label class="size-14">Date Sent: {{ date('M d, Y h:i A', strtotime($sms->created_at)) }}</label></span></h3>
				<h5></h5>
			</div>
			<label for="">Recipients: </label>
			<br/>
			<label for="">
			@foreach ($sms->sms_activity as $smsAct)
                @if($smsAct->recipient_team_id == 0)
					<a href="{{ route('recipient.edit', $smsAct->recipient_number->recipient->id) }}"  data-popover="true" data-html="true" title="<label>Recipient Information</label>" data-trigger="hover" data-content="
				<label>Sent Status (SENT/FAILED): <a>{{ $smsAct->status }}</a></label>
				<label>Receiving Number: <a>{{ $smsAct->recipient_number->phone_number }}</a></label>
				<div class='sep-1'></div>
				<label>Groups: @foreach($smsAct->recipient_number->recipient->teams as $recipient_team) <a href='{{ route('team.edit', $recipient_team->id) }}'>{{ $recipient_team->name }}</a>, @endforeach</label>
				<label>Recipient's Contacts: @foreach($smsAct->recipient_number->recipient->phoneNumbers as $phoneNumber)<a>{{ $phoneNumber->phone_number }}</a>, @endforeach
							">
						{{ $smsAct->recipient_number->recipient->name }}
					</a>
					<br>
				@endif
			@endforeach
			</label>
			<br/><br/><br/>
			<label for="">Groups: </label>
			<br/>
            <label for="">
			<?php $smsActivities = $sms->getRelatedTeams() ?>
			@foreach ($smsActivities as $smsActivity)
				@if($smsActivity->team)
					<a href="#" id="groupLink" data-popover="true" data-html="true" data-placement="right" title="<label>Group Members</label>" data-trigger="hover" data-content="
				    @foreach( $smsActivity->team->recipients as $recipient )
				    	<label><a href='{{ route('recipient.edit', $recipient->id) }}'>{!! $recipient->name !!}</a></label><br>
				    @endforeach">{{ $smsActivity->team->name }}
			    	</a>
					<br>
				@endif
			@endforeach
            </label>
			<br/><br/><br/>
			<label for="message">Message:</label>
			<br/>
			{!! Form::textarea('message', $sms->message, ['class'=>'form-control', 'disabled']) !!}
			<br/>
		</div>
    </div>

</div>
@stop

@section('script')
<script>
	var originalLeave = $.fn.popover.Constructor.prototype.leave;
    $.fn.popover.Constructor.prototype.leave = function(obj){
      var self = obj instanceof this.constructor ?
        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
      var container, timeout;

      originalLeave.call(this, obj);

      if(obj.currentTarget) {
        container = $(obj.currentTarget).siblings('.popover')
        timeout = self.timeout;
        container.one('mouseenter', function(){
          //We entered the actual popover – call off the dogs
          clearTimeout(timeout);
          //Let's monitor popover content instead
          container.one('mouseleave', function(){
            $.fn.popover.Constructor.prototype.leave.call(self, self);
          });
        })
      }
    };


    $('body').popover({ selector: '[data-popover]', trigger: 'click hover', placement: 'right', delay: {show: 50, hide: 50}});

	//$('#groupLink').tooltip('toggle')
</script>
@stop