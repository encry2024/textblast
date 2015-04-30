@extends('app')



@section('content')
<div class="container">
<br/><br/><br/>
<input type="text" id="text" name="tags[]"/>
<div id="contactList"></div>
</div>
@stop



@section('script')
<script>
	$(document).ready(function() {

		//The demo tag array
		var availableTags = [];
		$.getJSON("{!! URL::to('/') !!}/retrieve/contacts", function(data) {
			$.each(data, function(key, val) {
				availableTags.push(val.dta + "<i>" + val.phne, val.id);
			});
		});
		//The text input
		var input = $("input#text");

		//The tagit list
		var instance = $("<ul class=\"tags\"></ul>");

		//Store the current tags
		//Note: the tags here can be split by any of the trigger keys
		//      as tagit will split on the trigger keys anything passed
		var currentTags = input.val();

		//Hide the input and append tagit to the dom
		input.hide().after(instance);

		//Initialize tagit
		instance.tagit({
			tagSource:availableTags,
			fieldName: "items[]",
			tagsChanged:function () {

			//Get the tags
				var tags = instance.tagit('tags[]');
				var tagString = [];

			//Pull out only value
				for (var i in tags) {
					tagString.push(tags[i].value);
				}

			//Put the tags into the input, joint by a ','
			input.val(tagString.join(','));
			}
		});

	});
</script>
@stop