@extends('layouts.app')

@section('content')
<div class="container">
    @include('partials.validation-errors')
    <form method="POST" action="{{route('contacts.update', $contact)}}">
        @method('PUT')
        @include('contacts._form')
    </form>
</div>
@endsection