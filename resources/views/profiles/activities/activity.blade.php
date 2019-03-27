<div class="card mb-1">
    <div class="card-header">
        <div class="level">
            <div class="flex">
             {{ $heading }}
            </div>
            <div>
                {{-- Posted {{ $thread->created_at->diffForHumans() }} --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $body }}
    </div>
</div>