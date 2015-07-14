@extends('app')

@section('header')
	@include('util.m-topbar')
@stop

@section('content')
	<div class="container">
		<div class="col-lg-3">
			<br/>
			<div class="panel panel-default col-lg-12">
				<div class="panel-body left col-lg-12">
					<a href="{{route('user.index') }}" class="col-lg-12"><span class="glyphicon glyphicon-menu-left" ></span> Back to Users</a>
				</div>
			</div>
		</div>
		<!-- USER PROFILE -->
		<div class="col-lg-9">
		<br/>
			<div class="panel panel-default col-lg-12">
				<h3><span class="glyphicon glyphicon-user"></span> {{ $user->name }} </h3>
				<hr>
				<br/>
					<form class="form-horizontal" action="{{ url("user/{$user->id}/permission_update") }}" method="post">
						<div class="form-group">
							<label class="size-14 control-label col-lg-3 col-lg-pull-1" for="email">E-mail:</label>
							<div class="col-lg-6">
								<input class="form-control" id="email" type="string" value="{{ $user->email }}" disabled="true">
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="size-14 control-label col-lg-3 col-lg-pull-1" for="email">Account Type:</label>
							<div class="col-lg-6">
								<label class="checkbox-inline">
									<input type="radio" value="user" name="role" {{ $user->hasRole('user')?'checked="checked"':'' }}> User
								</label>
								<label class="checkbox-inline">
									<input type="radio" value="admin" name="role" {{ $user->hasRole('admin')?'checked="checked"':'' }}> Admin
								</label>
							</div>
							<input type="submit" id="permissions_updater" class="btn btn-danger" value="UPDATE">
						</div>
						<hr>
						<form id="frm_usr_updte" class="frm_usr_updte" action="POST">
							<input type="hidden" name="_method" value="PATCH">
							<input name='_token' type='hidden' value='{{ csrf_token() }}'>

							<div id="status_div" class="form-group {{ $user->status!=1 ? 'has-error':'has-success' }} has-feedback">
								<label class="size-14 control-label col-lg-3 col-lg-pull-1">Account Status: </label>
								<div class="col-lg-6">
									<input class="form-control" id="user_status" name="user_status" type="string" value="{{ $user->status!=1 ? 'INACTIVE':'ACTIVE' }}" disabled="true">
								</div>
								<input type="submit" id="status_updater" class=" btn {{ $user->status!=1 ? 'btn-success':'btn-danger' }} btn-update" value="{{ $user->status!=1 ? 'ACTIVATE':'DEACTIVATE' }}">
							</div>
						</form>


					</form>
				<br/><br/>
			</div>
			<!-- USER SMS ACTIVITY LOG -->
			<div class="panel panel-default col-lg-12">
				<h3> <span class="glyphicon glyphicon-envelope"></span> SMS Activity Log</h3>
				<hr>
				<br/>
						
				<br/><br/>
			</div>
		</div>
		<div id="ohsnap"></div>
		{!! Form::hidden('status', $user->status!=1 ? 1:0, ['id' => 'stts']) !!}
	</div>
@stop

@section('script')
<script type="text/javascript">
	$.ajaxSetup({
	   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});

	$(document).on('submit', '#frm_usr_updte', function() {
		var $post              = {};
		var submit 			   = $(".btn-update");
		var methodType         = $("input[name=_method]").val();
		var url                = "{{ route('user.update', [$user->id]) }}";
		$post.status 		   = $("input[name=status]").val();
		$post.token            = $("input[name=_token]").val();
		
		//e.preventDefault();
		$.ajax({
			type: methodType,
			url: url,
			data: $post,
			cache: false,
			beforeSend: function() {;
				submit.html('{{ $user->status!=1 ? "ACTIVATING....":"DEACTIVATING...." }}'); // change submit button text
				submit.removeClass('before');
				submit.addClass('disabled');
			},
			success: function() {
				$.getJSON('{{ route("fetchStatus", $user->id) }}', function(data) {
					submit.removeClass('disabled');
					console.log(data);
					$("#user_status").val(data);
					if (data != "INACTIVE") {
						submit.val("DEACTIVATE")
							  .removeClass("btn-success")
							  .addClass("btn-danger");
						$("#stts").val("0");
						$("#status_div").removeClass("has-error").addClass("has-success");
						console.log($("#stts"));
						ohSnap('Account has been activated', "green", 'glyphicon glyphicon-ok-sign');
					} else {
						submit.val("ACTIVATE")
							  .removeClass("btn-danger")
							  .addClass("btn-success");
						$("#stts").val("1");
						$("#status_div").removeClass("has-success").addClass("has-error");
						console.log($("#stts").val());
						ohSnap('Account has been deactivated', "orange", 'glyphicon glyphicon-ok-sign');
					}
				});
			},
			error: function() {
				ohSnap('Action was unsuccessful', 'orange');
			}
		});

		return false;
	});

</script>
@stop