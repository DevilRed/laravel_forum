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
                    @include("profiles.activities.{$activity->type}")
                @endforeach

{{--                {{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection
