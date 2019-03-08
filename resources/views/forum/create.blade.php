@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Thread</div>

                <div class="card-body">

                    <form action="/threads" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" value="{{old('title')}}" type="text" name="title" id="title">
                        </div>

                        <div class="form-group">
                            <label for="channel-id">Channel</label>
                            <select class="form-control" name="channel_id" id="channel-id">
                                <option value="">--Choose--</option>
                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}" {{ $channel->id == old('channel_id') ? 'selected' : ''}} > {{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="body">Message</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>

                        <input class="btn btn-primary" type="submit" value="submit">

                    </form>   

                    @if(count($errors))
                    <ul class="alert-warning">
                        @foreach($errors->all() as $error)
                           <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
