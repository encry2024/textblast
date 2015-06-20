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
		<br/><br/><br/><br/>
		<div class="offset1 span8">
			<div class="panel panel-default">
				<div class="panel-body">
					Legends:<br>
					<br/>
					<span class="label label-primary">PENDING</span>
					<span class="label label-success">SUCCESS</span>
					<span class="label label-danger">FAILED</span>
				</div>
			</div>
		</div>
	</div>
    <div class="col-lg-9 col-md-offset-center-2">
		<div class="panel panel-default col-lg-12">
			<div class="page-header">
<<<<<<< HEAD
				<h3><span class="glyphicon glyphicon-send"></span> Sent Messages <br><span><label class="size-14">Sender: {{ isset($sms->user->name)?$sms->user->name:'No sender information' }}</label></span><span class="right"><label class="size-14">Date Sent: {{ date('M d, Y h:i A', strtotime($sms->created_at)) }}</label></span></h3>
=======
				<h3><span class="glyphicon glyphicon-envelope"></span> SMS Details <span class="right"><label class="size-14">Date Sent: {{ date('M d, Y h:i A', strtotime($sms->created_at)) }}</label></span></h3>
				<h5></h5>
			</div>
			<div class="offset1 span8 pull-right">
				<div class="panel panel-default">
					<div class="panel-body">
						Legends:<br>
						<span class="label label-primary">PENDING</span>
						<span class="label label-success">SUCCESS</span>
						<span class="label label-danger">FAILED</span>
					</div>
				</div>
>>>>>>> 668527b282e14bc79ee6649696674b877f7ae424
			</div>
			<div class="col-lg-6">
				<label for="">Recipients: </label>
				<br/>
				<label for="">
				@foreach ($sms->sms_activity as $smsAct)
					@if($smsAct->recipient_team_id == 0)
						<button style=" margin-bottom: 0.25rem; " class="{{ $smsAct->status=='SENT'?'btn btn-success':($smsAct->status=='FAILED'?'btn btn-danger':'') }}" data-toggle="popover" data-html="true" title="<label>Recipient Information</label><button type='button' class='close' data-dismiss='popover' aria-hidden='true'>&times;</button>" data-trigger="click" data-content="
						<body>
							<form id='frm_resend' class='resend' action='POST'>
								<label>SMS Status: <a>{{ $smsAct->status }}</a> <span>{!! $smsAct->status=='FAILED'?'<button class=&apos;btn btn-info btn-xs button-refresh&apos; id=&apos;'.$smsAct->id.' type=&apos;submit&apos;>Resend</button>':'' !!}</span></label></label>
								<label>Receiving Number: <a>{{ $smsAct->recipient_number->phone_number }}</a></label>
								<div class='sep-1'></div>
								<label>Groups: @foreach($smsAct->recipient_number->recipient->teams as $recipient_team) <a href='{{ route('team.edit', $recipient_team->id) }}'>{{ $recipient_team->name }}</a>, @endforeach</label>
								<label>Recipient's Contacts: @foreach($smsAct->recipient_number->recipient->phoneNumbers as $phoneNumber)<a>{{ $phoneNumber->phone_number }}</a>, @endforeach
								<label><a href='{{ route('recipient.edit', $smsAct->recipient_number->recipient->id) }}'>view profile </a>
							</form>
						</body>
						">
						{{ $smsAct->recipient_number->recipient->name }} ({{ $smsAct->recipient_number->phone_number }})
						</button>

					@endif
				@endforeach
				</label>
				<br/><br/><br/>
			</div>

			<div class="col-lg-6">
				<label for="">Groups: </label>
				<br/>
				<label for="">
				<?php $currentTeam = 0 ?>
				@foreach ($sms->sms_activity as $smsAct)
					@if($smsAct->recipient_team_id != 0)
						@if($currentTeam != $smsAct->recipient_team_id)
							<?php $currentTeam = $smsAct->recipient_team_id ?>
							<br>
							<a href="#" id="groupLink">{{ $smsAct->team->name }}</a>
						@endif
						<li>
						<button class="{{ $smsAct->status=='SENT'?'btn btn-success':($smsAct->status=='FAILED'?'btn btn-danger':'') }}" data-popover="true" data-html="true" title="<label>Recipient Information</label><button type='button' class='close' data-dismiss='popover' aria-hidden='true'>&times;</button>" data-trigger="click" data-content="
						<body>
							<form id='frm_resend' class='resend' action='POST'>
								<label>SMS Status: <a>{{ $smsAct->status }}</a> <span>{!! $smsAct->status=='FAILED'?'<button class=&apos;btn btn-info btn-xs button-refresh&apos; id=&apos;'.$smsAct->id.' type=&apos;submit&apos;>Resend</button>':'' !!}</span></label></label>
								<label>Receiving Number: <a>{{ $smsAct->recipient_number->phone_number }}</a></label>
								<div class='sep-1'></div>
								<label>Groups: @foreach($smsAct->recipient_number->recipient->teams as $recipient_team) <a href='{{ route('team.edit', $recipient_team->id) }}'>{{ $recipient_team->name }}</a>, @endforeach</label>
								<label>Recipient's Contacts: @foreach($smsAct->recipient_number->recipient->phoneNumbers as $phoneNumber)<a>{{ $phoneNumber->phone_number }}</a>, @endforeach
								<label><a href='{{ route('recipient.edit', $smsAct->recipient_number->recipient->id) }}'>view profile </a>
							</form>
						</body>
						">
						{{ $smsAct->recipient_number->recipient->name }} ({{ $smsAct->recipient_number->phone_number }})
						</button>
						</li>
					@endif
				@endforeach
				</label>
				<br/><br/><br/>
			</div>
			<br/>
			<br/>
			<div class="col-lg-12">
				<label for="message">Message:</label>
				<br/>
				{!! Form::textarea('message', $sms->message, ['class'=>'form-control', 'disabled']) !!}
				<br/>
			</div>
		</div>
    </div>
</div>
<div id="ohsnap"></div>
@stop

@section('script')
<script>
	$.ajaxSetup({
	   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});

	$(document).on('submit', 'form', function() {
		var $post              = {};
		$post.id    		   = $(".button-refresh").attr('id');
		var url                = "{{ url().'/sms/resend/' }}" + $post.id;
		var submit 			   = $(".button-refresh");
		$post.token            = $("input[name=_token]").val();
		var methodType         = $("input[name=_method]").val();
		//e.preventDefault();
		$.ajax({
			type: 'POST',
			url: url,
			data: $post,
			cache: false,
			beforeSend: function() {;
				submit.html('Resending....'); // change submit button text
				submit.removeClass('before');
				submit.addClass('disabled');
				ohSnap('Resending....', 'blue', 'glyphicon glyphicon-info-sign');
			},
			success: function() {
				submit.hide();
				ohSnap('Resend successful!', 'green', 'glyphicon glyphicon-ok-sign');
			},
			error: function() {
				ohSnap('Resend was unsuccessful', 'orange');
			}
		});

		return false;
	});


	$.fn.extend({
		popoverClosable: function (options) {
			var defaults = {
				template:
				'	<div class="popover">\
					<div class="arrow"></div>\
					<div class="popover-header">\
					<button type="button" class="close col-lg-push-1" data-dismiss="popover" aria-hidden="true">&times;</button>\
					<h3 class="popover-title"></h3>\
					</div>\
					<div class="popover-content"></div>\
					</div>\
				'
			};
			options = $.extend({}, defaults, options);
			var $popover_togglers = this;
			$popover_togglers.popover(options);
			$popover_togglers.on('click', function (e) {
				e.preventDefault();
				$popover_togglers.not(this).popover('hide');
			});
			$('html').on('click', '[data-dismiss="popover"]', function (e) {
				$popover_togglers.popover('hide');
			});
		}
	});

	$('[data-toggle="popover"]').popover({ container: 'body', trigger: 'click', placement: 'right'});
	$('[data-popover="true"]').popover({trigger: 'click', placement: 'bottom', delay: {show: 50, hide: 50}});
	$(function () {
		$('[data-toggle="popover"]').popoverClosable();
		$('[data-popover="true"]').popoverClosable();
	});


    //$('body').popover({ selector: '[data-popover]', trigger: 'hover', placement: 'right', delay: {show: 50, hide: 50}});


	/*$('.button-refresh').click(function(){
		var id = $(this).attr('id');
		var $btn = $(this).button('loading');
		var button = $(this);

		$.get( "{{ url().'/sms/resend/' }}" + id).done(function( data ) {
			console.log(data);
			if(data=='DONE') {
				// change hyperlink color to blue
				button.siblings('a').attr('style', 'color:#337ab7');
				button.hide();
			}
		});
	});*/

</script>
@stop