<div class="col-lg-2">
	<label data-toggle="tooltip" data-placement="right" data-html="true" title="{{ date('F d, Y h:i a', strtotime($event->created_at))  }}">
		<i>{{ $event->created_at->diffForHumans() }}</i>
	</label>
</div>
<div class="col-lg-8">
@if($event->user_id != 0)
<a href="{{ route('user.show', $event->user->id) }}">{{ $event->user->name }}</a> removed <code>{{$event->subject->name}}</code> from the contacts
@endif
</div>