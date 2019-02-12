@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="#">{{$thread->author->name}}</a> posted {{$thread->title}}</div>
                <div class="card-body">
                    <article>
                        <div>{{$thread->body}}</div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            @foreach($thread->replies as $reply)
                @include('forum.reply')
            @endforeach     
        </div>
    </div>

    @if(auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <form action="{{ $thread->path().'/replies' }}" method="POST">
               @csrf
               <div class="input-group">
                    <textarea class="form-control" name="body" id="body" rows="3" placeholder="Have something to say.."></textarea>
               </div>
               <div class="input-group justify-content-end mt-4">
                    <input type="submit" class="btn btn-default" value="Submit">
               </div>
            </form>
        </div>
    </div>
    
    @else
    <div class="text-center">
        Please <a href="{{ route('login')}}">SignIn</a> to participate
    </div>
    @endif

</div>
@endsection
