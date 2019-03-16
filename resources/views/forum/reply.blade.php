<div class="card mt-2">
    <div class="card-header">
        <div class="level">
            <div class="flex">
                <a href="#">{{$reply->owner->name}}</a>
                created at {{$reply->created_at->diffForHumans()}}
            </div>
            <div>
                {{ $reply->isFavorited() }}
                <form action="{{ url('/replies/'.$reply->id.'/favorite') }}" method="post">
                    @csrf()
                    <input class="btn btn-sm btn-default" {{ ($reply->isFavorited()) ? 'disabled' : '' }} type="submit" value="{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count )}}">
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <article>
            <div>{{$reply->body}}</div>
        </article>
    </div>
</div>