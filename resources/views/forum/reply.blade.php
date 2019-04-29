<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mt-2">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                <a href="{{ route('profiles', $reply->owner->name )}}">{{$reply->owner->name}}</a>
                    created at {{$reply->created_at->diffForHumans()}}
                </div>
                <div>
                    <form action="{{ url('/replies/'.$reply->id.'/favorite') }}" method="post">
                        @csrf()
                        <input class="btn btn-sm btn-default" {{ ($reply->isFavorited()) ? 'disabled' : '' }} type="submit" value="{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count )}}">
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" name="editreply" id="editreply" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <article v-else v-text="body">
            </article>

        </div>

        @can('update', $reply)
        <div class="card-footer level">
            <button class="btn btn-sm btn-link mr-1" @click="editing = true">Edit</button>
            <form action="/replies/{{$reply->id}}" method="post">
                @csrf()
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
        @endcan
    </div>
</reply>
