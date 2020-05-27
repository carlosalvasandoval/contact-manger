<h4>we couldn't import your contacts because of some errors in your file</h4>
@foreach($failures as $failure)
<ul>
    @foreach($failure->toArray() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>
@endforeach