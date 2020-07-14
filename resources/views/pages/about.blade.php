@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    <h2>Skills:</h2>
    @if(count($skills) > 0)
        <ul class="list-group">
            @foreach($skills as $skill)
                <li class="list-group-item">{{$skill}}</li>
            @endforeach
        </ul>
    @endif
@endsection
