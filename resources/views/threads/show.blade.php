@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name }}</a> posted:
                    {{$thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    @foreach($replies as $reply)
                        @include('threads.reply')
                    @endforeach
                {{ $replies->links() }}

                    @if(auth()->check())
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                                    </div>

                                    <button class="btn btn-default" type="submit">Post</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }}
                            {{Str::plural('comment', $thread->replies_count)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
