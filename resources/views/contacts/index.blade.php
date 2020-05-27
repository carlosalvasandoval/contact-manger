@extends('layouts.app')

@section('content')
<div class="container">
	<h1>My contacts</h1>
	<form method="POST" action="{{route('tracks.track')}}" id="form-track">
		@csrf
		<button class="btn btn-info float-left mr-3" href="{{route('tracks.track')}}" id="track-event">Track event</button>
	</form>
	<a class="btn btn-warning float-left" href="{{route('contacts.import')}}" id="track-event">Import contact CVS</a>
	<a class="btn btn-outline-success float-right mb-3" href="{{route('contacts.create')}}">Add new contact</a>
	<table class="table table-striped">
		<tr>
			<th>First Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Actions</th>
		</tr>
		@foreach($contacts as $contact)
		<tr>
			<td>{{$contact->first_name}}</td>
			<td>{{$contact->email}}</td>
			<td>{{$contact->phone}}</td>
			<td>
				<form class="float-right" method="POST" action="{{route('contacts.destroy', $contact)}}">
					@csrf @method('DELETE')
					<button class="btn btn-outline-danger btn-sm">Delete</button>
				</form>
				<a class="btn btn-outline-dark btn-sm float-right mr-3" href="{{route('contacts.edit', $contact)}}">Edit</a>

			</td>
		</tr>
		@endforeach
	</table>
	{{$contacts->links()}}
</div>
@push('scripts')
	<script>
		$(document).ready(function(){
			var trackEventButton = $('#track-event');
			trackEventButton.on('click', function(e) {
				var formTrack = $('#form-track');
				e.preventDefault();
				$.ajax({
					url: formTrack.attr('action'),
					type: 'POST',
					data: formTrack.serializeArray(),
					beforeSend: function(){
						trackEventButton.attr('disabled','disabled');
					},
					success: function(data){
						trackEventButton.removeAttr('disabled');
						if(data == 1 ){
							alert('Action Tracked');
						}
					}, 
					error: function(){
						trackEventButton.removeAttr('disabled');
					}

				});
			})
		});
	</script>
@endpush

@endsection