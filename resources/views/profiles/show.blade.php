@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>
{{--                        {{ $profileUser->name }}--}}
{{--                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>--}}
                    </h1>
                </div>

                @foreach($activities as $activity)
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    @include("profiles.activities.{$activity->type}")
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $activity->subject->body }}
                        </div>
                    </div>
                @endforeach

{{--                {{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection
