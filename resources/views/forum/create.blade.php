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
                            <input class="form-control" type="text" name="title" id="title">
                            <input type="hidden" name="channel_id">
                        </div>
                        <div class="form-group">
                            <label for="body">Message</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                        
                        <input type="submit" value="submit">

                    </form>   
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
