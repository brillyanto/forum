@extends('layouts.app')

@section('content')

<div class="container">
    <div class="page-header">
        <h3>{{ $user->name}}</h3> since {{$user->created_at->diffForHumans() }}
    </div>
    <hr>
    @foreach($activities as $date => $activityCollection)
        <h3>{{ $date }}</h3>
        @foreach($activityCollection as $activity)
            @include('profiles.activities.'. $activity->type )
        @endforeach
    @endforeach

    {{-- {{ $threads->links() }} --}}
    
</div>

@endsection