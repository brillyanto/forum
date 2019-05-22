@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">
                <div class="level">
                    <span class="flex">
                        <a href="{{ route('profiles', $thread->author->name) }}">{{$thread->author->name}}</a>
                         posted {{$thread->title}}
                    </span>
                    @can('update', $thread)
                    <span>
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-link" type="submit">Delete</button>        
                        </form>
                    </span>
                    @endcan
                </div>
                
            </div>
                <div class="card-body">
                    <article>
                        <div>{{$thread->body}}</div>
                    </article>
                </div>
            </div>
            
            <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

            <br>

            {{-- {{  $replies->links() }} --}}
               
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
                    <p>Created {{ $thread->created_at->diffForHumans() }} by 
                        <a href="{{ route('profiles', $thread->author->name) }}">
                            {{ $thread->author->name }}</a>, 
                            and has <span v-text="repliesCount">
                                </span> {{ str_plural('comment', $thread->replies_count)}}.</p>
                </div>
            </div>
        </div>

    </div>
</div>
</thread-view>
@endsection
