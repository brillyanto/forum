@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"><a href="{{ route('profiles', $thread->author->name) }}">{{$thread->author->name}}</a> posted {{$thread->title}}</div>
                <div class="card-body">
                    <article>
                        <div>{{$thread->body}}</div>
                    </article>
                </div>
            </div>
            
            @foreach($replies as $reply)
                @include('forum.reply')
            @endforeach     

            <br>

            {{  $replies->links() }}
               
            @if(auth()->check())
            <form action="{{ $thread->path().'/replies' }}" method="POST">
            @csrf
            <div class="input-group">
                    <textarea class="form-control" name="body" id="body" rows="3" placeholder="Have something to say.."></textarea>
            </div>
            <div class="input-group justify-content-end mt-4">
                    <input type="submit" class="btn btn-default" value="Submit">
            </div>
            </form>
            @else
            <div class="text-center">
                Please <a href="{{ route('login')}}">SignIn</a> to participate
            </div>
            @endif

        </div>
        <div class="col-md-4">
        <div class="card">
                <div class="card-body">
                    <p>Created {{ $thread->created_at->diffForHumans() }} by <a href="{{ route('profiles', $thread->author->name) }}">{{ $thread->author->name }}</a>, and has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count)}}.</p>
                </div>
            </div>
        </div>

    </div>
   

    

</div>
@endsection
