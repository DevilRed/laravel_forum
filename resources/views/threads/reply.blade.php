<div class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}...
            </h5>
        </div>
        <div>
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites()->count() }} {{ Str::plural('Favorite', $reply->favorites()->count()) }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
