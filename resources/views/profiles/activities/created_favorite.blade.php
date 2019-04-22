@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $user->name }} favorited a reply
        </a>
        {{-- <a href="{{$activity->subject->reply->path()}}">reply</a> --}}
    @endslot
    @slot('body')
        {{$activity->subject->favorited->body}}
    @endslot
@endcomponent
