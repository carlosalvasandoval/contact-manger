@extends('layouts.app')

@section('content')
<div class="container">
    @include('partials.validation-errors')
    <form method="POST" action="{{route('contacts.import')}}" enctype='multipart/form-data'>
        @csrf
        <div class="form-group">
            <label for="file">Upload your csv contacts file</label>
            <input type="file" class="form-control" name="file">
            <small class="form-text text-muted">
                Please before submit a file follow the next instruccions
                <ul>
                    <li>The max file size must be 5MB</li>
                    <li>The file type must be cvs</li>
                    <li>Download the appropiate format file <a href="{{Storage::url('sampleCsv.csv')}}">
                            download csv file format </a>
                    </li>
                </ul>
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Import CVS</button>
    </form>
</div>
@endsection