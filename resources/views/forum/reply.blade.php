<div class="card mt-2">
    <div class="card-header"><a href="#">{{$reply->owner->name}}</a> created at {{$reply->created_at->diffForHumans()}}</div>
    <div class="card-body">
        <article>
            <div>{{$reply->body}}</div>
        </article>
    </div>
</div>