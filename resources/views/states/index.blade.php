@extends('layouts.app')

@section('content')
    <h1>States</h1>
    @if(count($states) > 0)
        @foreach($states as $state)
            <div>
                <h3>{{$state->name}}</h3>
            </div>
        @endforeach
    @else
        <p>no states in database.</p>
    @endif
@endsection