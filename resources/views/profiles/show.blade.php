@extends('layouts.app')

@section('content')

<div class="container">
    <div class="page-header">
        <h3>{{ $user->name}}</h3> since {{$user->created_at->diffForHumans() }}
    </div>
    <hr>
    @foreach($threads as $thread)
    <div class="card mb-1">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                <a href="{{ url($thread->path()) }}">{{ $thread->title }}</a>
                </div>
                <div>
                    Posted {{ $thread->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $thread->body }}
        </div>
    </div>
    @endforeach

    {{ $threads->links() }}
    

</div>

@endsection