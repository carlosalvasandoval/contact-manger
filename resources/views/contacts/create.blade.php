@extends('layouts.app')

@section('content')
<div class="container">
  @include('partials.validation-errors')
    <form method="POST" action="{{route('contacts.store')}}">
        @include('contacts._form')
    </form>
</div>
@endsection