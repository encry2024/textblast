<div class="col-lg-2">
	<label data-toggle="tooltip" data-placement="right" data-html="true" title="{{ date('F d, Y h:i a', strtotime($event->created_at))  }}">
		<i>{{ $event->created_at->diffForHumans() }}</i>
	</label>
</div>
<div class="col-lg-8">
<a href="{{ route('user.show', $event->user->id) }}">{{ $event->user->name }}</a> removed <a href="{{ route('recipient.edit', $event->subject->id) }}">{{$event->subject->name}}</a> from the contacts
</div>