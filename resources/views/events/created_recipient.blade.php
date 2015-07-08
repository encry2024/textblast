<div class="col-lg-2">
	<label data-toggle="tooltip" data-placement="right" data-html="true" title="{{ date('F d, Y h:i a', strtotime($event->created_at))  }}">
		<i>{{ $event->created_at->diffForHumans() }}</i>
	</label>
</div>
<div class="col-lg-8">
<a href="{{ route('user.show', $event->user->id) }}">{{ $event->user->name }}</a> added <a href="{{ route('recipient.show', $event->subject->id) }}">{{$event->subject->name}}</a> to the contacts
</div>